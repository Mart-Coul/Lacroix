<?php

namespace Lacroix\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="data_entries")
 */
class DataEntry {
  /**
   * @ORM\Id
   * @ORM\Column(type="integer");
   * @ORM\GeneratedValue(strategy="AUTO");
   */
  protected $id;

  /**
   * @ORM\Column(type="integer")
   */
  protected $created_at;

  /**
   * @ORM\Column(type="integer")
   */
  protected $reading;

  /**
   * @ORM\Column(type="integer")
   */
  protected $employees;

  /**
   * @ORM\Column(type="string")
   */
  protected $notes;

  /**
   * @ORM\ManyToOne(targetEntity="Product", fetch="LAZY")
   * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
   */
  protected $product;

  /**
   * @ORM\ManyToOne(targetEntity="ProductionLine", fetch="LAZY")
   * @ORM\JoinColumn(name="production_line_id", referencedColumnName="id")
   */
  protected $production_line;

  public function getSpeed() {
    // TODO
    return $this->getReading();
  }

  public function getAdjustmentRecommentations() {
    // TODO
    return array();
  }

  /*
   * Misc getters / setters
   */

  public function getId() {
    return $this->id;
  }

  public function getCreatedAt() {
    return $this->created_at;
  }

  public function getReading() {
    return $this->reading;
  }

  public function getEmployees() {
    return $this->employees;
  }

  public function getNotes() {
    return $this->notes;
  }

  public function getProductionLine() {
    return $this->production_line;
  }

  public function getProduct() {
    return $this->product;
  }

  public function setCreatedAt($value) {
    $this->created = $value;
    return $this;
  }

  public function setReading($value) {
    $this->reading = $value;
    return $this;
  }

  public function setEmployees($value) {
    $this->employees = $value;
    return $this;
  }

  public function setNotes($value) {
    $this->notes = $value;
    return $this;
  }

  public function setProductionLine($value) {
    $this->production_line = $value;
    return $this;
  }

  public function setProduct($value) {
    $this->product = $value;
    return $this;
  }
}