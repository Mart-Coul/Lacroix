<?php

namespace Lacroix\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="products")
 */
class Product {
  /**
   * @ORM\Id
   * @ORM\Column(type="integer");
   * @ORM\GeneratedValue(strategy="AUTO");
   */
  protected $id;

  /**
   * @ORM\Column(type="string")
   */
  protected $name;

  /**
   * @ORM\Column(type="integer")
   */
  protected $target_productivity;

  /*
   * Misc getters / setters
   */

  public function getId() {
    return $this->id;
  }

  public function getName() {
    return $this->name;
  }

  public function getTargetProductivity() {
    return $this->target_productivity;
  }

  public function setName($value) {
    $this->name = $value;
    return $this;
  }

  public function setTargetProductivity($value) {
    $this->target_productivity = $value;
    return $this;
  }
}