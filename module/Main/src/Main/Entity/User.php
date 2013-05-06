<?php

namespace Main\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Zend\Permissions\Acl\Resource\GenericResource;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User {
  const STATIC_SALT = '78r9esr789fd';

  /**
   * @ORM\Id
   * @ORM\Column(type="integer");
   * @ORM\GeneratedValue(strategy="AUTO");
   */
  protected $id;

  /**
   * @ORM\Column(type="string")
   */
  protected $email;

  /**
   * @ORM\Column(type="string")
   */
  protected $password;

  /**
   * @ORM\Column(type="string")
   */
  protected $salt;

  /**
   * @ORM\ManyToOne(targetEntity="Person", fetch="EAGER", cascade={"persist"})
   * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
   */
  protected $person;

  /**
   * @ORM\OneToMany(targetEntity="UserRole", fetch="LAZY", mappedBy="user", cascade={"all"})
   */
  protected $roles;

  public function __construct() {
    $this->roles = new ArrayCollection();
    $this->salt = md5(uniqid());
  }

  public function hasRole($role_slug) {
    return in_array($role_slug, 
                    $this->getRoleNames());
  }

  public function toggleRole($em, $role, $flag) {
    if ($this->hasRole($role) && !$flag) {
      $this->removeRole($em, $role);
    } elseif (!$this->hasRole($role) && $flag) {
      $this->addRole($role);
    };
  }

  public function addRole($role_slug) {
    $role = new \Main\Entity\UserRole();
    $role
      ->setUser($this)
      ->setRole($role_slug);
    $this->getRoles()->add($role);

    return $this;
  }

  public function removeRole($em, $role_slug) {
    $roles = $this->getRoles();

    foreach ($roles->toArray() as $role) {
      if ($role->getRole() == $role_slug) {
        $roles->removeElement($role);
        $em->remove($role);
      };
    };

    return $this;
  }

  public function getRoleNames() {
    return array_map(function($r) { return $r->getRole(); },
                     $this->getRoles()->toArray());
  }

  public function isAllowed($acl, $controller, $action, $extra_roles = array('user')) {
    if (!$acl->hasResource($controller)) {
      $acl->addResource(new GenericResource($controller));
    };

    $roles = array_merge($extra_roles,
                         $this->getRoleNames());

    foreach ($roles as $role) {
      if (!$acl->hasRole($role)) { continue; };
      if ($acl->isAllowed($role, 
                          $controller, 
                          $action)) {
        return true;
      };
    };

    return false;
  }

  public function getOrCreatePerson() {
    $person = $this->getPerson();
    if (!$person) {
      $person = $this->createPerson();
    };

    return $person;
  }

  public function createPerson() {
    $person = new Person;
    $person->setFirstName('');
    $person->setLastName('');
    $this->setPerson($person);
    return $person;
  }

  public function toResponse() {
    return array('id' => $this->getId(),
                 'email' => $this->getEmail(),
                 'person' => $this->getPerson() ? $this->getPerson()->toResponse() : null);
  }

  public function getUsername() {
    return $this->getEmail();
  }

  public function getFullName() {
    if ($this->getPerson()) {
      return $this->getPerson()->getFullName();
    };

    return $this->getEmail();
  }
  
  public function hashPassword($password) {
    return md5($password . self::STATIC_SALT . $this->getSalt());
  }

  /*
   * Misc getters / setters
   */

  public function getId() {
    return $this->id;
  }

  public function getSalt() {
    return $this->salt;
  }

  public function getPassword() {
    return $this->password;
  }

  public function getRoles() {
    return $this->roles;
  }

  public function getEmail() {
    return $this->email;
  }

  public function getPerson() {
    return $this->person;
  }
  
  public function setId($id) {
    $this->id = $id;
    return $this;
  }

  public function setEmail($value) {
    $this->email = $value;
    return $this;
  }
  
  public function setPassword($value) {
    $this->password = $this->hashPassword($value);
    return $this;
  }
  
  public function setSalt($value) {
    $this->salt = $value;
    return $this;
  }

  public function setPerson($value) {
    $this->person = $value;
    return $this;
  }
}