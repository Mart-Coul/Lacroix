<?php

namespace Main\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="user_roles")
 */
class UserRole {
  const ROLE_ADMIN = 'admin';
  const ROLE_PRODUCTION = 'production';

  /**
   * @ORM\Id
   * @ORM\Column(type="integer");
   * @ORM\GeneratedValue(strategy="AUTO");
   */
  protected $id;

  /**
   * @ORM\ManyToOne(targetEntity="User", fetch="LAZY")
   * @ORM\JoinColumn(name="user_id", referencedColumnName="id");
   */
  protected $user;

  /**
   * @ORM\Column(type="string")
   */
  protected $role;

  static public function getRoleList($t) {
    $roles = array();
    $roles[self::ROLE_ADMIN] = $t->translate('Admin');
    $roles[self::ROLE_PROCUCTION] = $t->translate('Production');
    return $roles;
  }

  /*
   * Misc getters / setters
   */

  public function getId() {
    return $this->id;
  }

  public function getUser() {
    return $this->user;
  }

  public function getRole() {
    return $this->role;
  }

  public function setUser($value) {
    $this->user = $value;
    return $this;
  }

  public function setRole($value) {
    $this->role = $value;
    return $this;
  }
}