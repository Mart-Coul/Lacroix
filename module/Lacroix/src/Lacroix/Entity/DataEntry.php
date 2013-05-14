<?php

namespace Lacroix\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Lacroix\Repository\DataEntry")
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
   * @ORM\Column(type="float")
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

  public function __construct() {
    $this->created_at = time();
  }

  public function getProductName() {
    return $this->getProduct()->getName();
  }

  public function getProductId() {
    return $this->getProduct()->getId();
  }

  public function getSpeed() {
    return $this->estimateSpeed($this->getReading());
  }

  public function estimateSpeed($value) {
    if (!$this->getEmployees()) {
      return 0;
    };

    return round($value * $this->getProductionLine()->getSpeedAdjustment() / $this->getEmployees(), 2);
  }

  public function getTargetProductivity() {
    return $this->getProduct()->getTargetProductivity();
  }

  public function getNumStars() {
    $over = $this->getSpeed() / $this->getTargetProductivity() - 1;
    if ($over < 0) {
      return 0;
    }

    return floor($over * 100 / $this->getProduct()->getStarPercent());
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