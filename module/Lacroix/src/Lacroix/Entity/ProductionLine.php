<?php

namespace Lacroix\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="production_lines")
 */
class ProductionLine {
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
   * @ORM\Column(type="float")
   */
  protected $speed_adjustment;

  /**
   * @ORM\ManyToOne(targetEntity="Room", fetch="LAZY")
   * @ORM\JoinColumn(name="room_id", referencedColumnName="id")
   */
  protected $room;

  // It is not a wise idea to add readings referencne here; as long as
  // array  reference  materializes  when accessed,  this  means  that
  // Doctrine would attempt  to read the complete entry  history for a
  // production line; use DataEntry  repository to access the requried
  // history subset instead

  /*
   * Misc getters / setters
   */

  public function getId() {
    return $this->id;
  }

  public function getName() {
    return $this->name;
  }

  public function getSpeedAdjustment() {
    return $this->speed_adjustment;
  }

  public function getRoom() {
    return $this->room;
  }

  public function setName($value) {
    $this->name = $value;
    return $this;
  }

  public function setSpeedAdjustment($value) {
    $this->speed_adjustment = $value;
    return $this;
  }

  public function setRoom($value) {
    $this->room = $value;
    return $this;
  }
}