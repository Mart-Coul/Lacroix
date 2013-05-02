<?php

namespace Main\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="people")
 */
class Person {
  /**
   * @ORM\Id
   * @ORM\Column(type="integer");
   * @ORM\GeneratedValue(strategy="AUTO");
   */
  protected $id;

  /**
   * @ORM\Column(type="string")
   */
  protected $first_name;

  /**
   * @ORM\Column(type="string")
   */
  protected $last_name;

  public function toResponse() {
    return array('id' => $this->getId(),
                 'first_name' => $this->getFirstName(),
                 'last_name' => $this->getLastName());
  }

  public function getFullName() {
    return sprintf('%s %s', 
                   $this->getFirstName(),
                   $this->getLastName());
  }

  /*
   * Misc getters / setters
   */

  public function getId() {
    return $this->id;
  }

  public function getFirstName() {
    return $this->first_name;
  }

  public function getLastName() {
    return $this->last_name;
  }

  public function setFirstName($value) {
    $this->first_name = $value;
    return $this;
  }

  public function setLastName($value) {
    $this->last_name = $value;
    return $this;
  }
}