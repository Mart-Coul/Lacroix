<?php

namespace Lacroix\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="products")
 */
class Room {
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
   * @ORM\OneToMany(targetEntity="ProductionLine", mappedBy="room")
   * @ORM\OrderBy({"name" = "ASC"})
   */
  protected $production_lines;

  public function __construct() {
    $this->production_lines = new ArrayCollection();
  }

  /*
   * Misc getters / setters
   */

  public function getId() {
    return $this->id;
  }

  public function getName() {
    return $this->name;
  }

  public function getProductionLines() {
    return $this->production_lines;
  }

  public function setName($value) {
    $this->name = $value;
    return $this;
  }
}