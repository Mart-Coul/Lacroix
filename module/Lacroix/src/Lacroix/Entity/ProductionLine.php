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


  protected $_data_entry_repository;
  protected $_translator;

  // It is not a wise idea to add readings referencne here; as long as
  // array  reference  materializes  when accessed,  this  means  that
  // Doctrine would attempt  to read the complete entry  history for a
  // production line; use DataEntry  repository to access the requried
  // history subset instead

  public function getRoomName() {
    $room = $this->getRoom();
    if (!$room) {
      return null;
    };

    return $room->getName();
  }

  public function getLastReading() {
    return $this->getDataEntryRepository()->getLastReadingForLine($this);
  }

  public function getLastProductName() {
    $reading = $this->getLastReading();
    return $reading ? $reading->getProductName() : $this->getTranslator()->translate('N/A');
  }

  public function getLastNotes() {
    $reading = $this->getLastReading();
    return $reading ? $reading->getNotes() : null;
  }

  public function getLastTeamLeader() {
    $reading = $this->getLastReading();
    return $reading ? $reading->getTeamLeader() : null;
  }
  
  public function getLastStars() {
    $reading = $this->getLastReading();
    return $reading ? $reading->getNumStars() : null;
  }

  public function getLastProductId() {
    $reading = $this->getLastReading();
    return $reading ? $reading->getProductId() : null;
  }

  public function getLastEmployees() {
    $reading = $this->getLastReading();
    return $reading ? $reading->getEmployees() : $this->getTranslator()->translate('N/A');
  }

  public function getLastSpeed() {
    $reading = $this->getLastReading();
    return $reading ? $reading->getSpeed() : $this->getTranslator()->translate('N/A');
  }

  public function getLastTargetProductivity() {
    $reading = $this->getLastReading();
    return $reading ? $reading->getTargetProductivity() : -1;
  }

public function getLastMainMetric() {
    $reading = $this->getLastReading();
    return $reading ? number_format(round($reading->estimateSpeed($reading->getReading()), 1),1) : $this->getTranslator()->translate('N/A');
  }

  public function getStatusClass() {
    if ($this->getLastSpeed() >= $this->getLastTargetProductivity()) {
      return 'ok';
    };

    return 'bad';
  }

  public function isUpdateMoreThanXHours($numberOfHours) {
    $reading = $this->getLastReading();
    if (!$reading) {
      return false;
    };

    return (time() - $reading->getCreatedAt()) / 3600 > $numberOfHours ? true : false;
  }

  public function getLastUpdateTime($format) {
    $reading = $this->getLastReading();
    if (!$reading) {
      return $this->getTranslator()->translate('N/A');
    };

    return $this->formatDateXTimeAgo($reading->getCreatedAt());
  }

  public function formatDateXTimeAgo($date) {
    $stf = 0;
	$cur_time = time();
	$diff = $cur_time - $date;
	$phrase = array('seconde','minute','heure','jour','semaine','mois','an','décennie');
	$length = array(1,60,3600,86400,604800,2630880,31570560,315705600);

	for($i = sizeof($length)-1; ($i >=0) && (($no =  $diff/$length[$i]) <= 1); $i--); if($i < 0) $i=0; $_time = $cur_time  -($diff%$length[$i]);
	$no = floor($no);
	if($no > 1 && substr($phrase[$i], strlen($phrase[$i])-1,1) != "s")  $phrase[$i] .='s';
	$value=sprintf("%d %s ",$no,$phrase[$i]);

	if(($stf == 1)&&($i >= 1)&&(($cur_tm-$_time) > 0)) $value .= time_ago($_time);

	return 'il y a ' . $value;
  }

  public function getProductivityOptions() {
    $reading = $this->getLastReading();
    if (!$reading) {
      return array();
    };

    return array(array('motor' => $reading->getReading() + 1,
                       'result' => $reading->estimateSpeed($reading->getReading() + 1)),
                 array('motor' => $reading->getReading() + 3,
                       'result' => $reading->estimateSpeed($reading->getReading() + 3)));
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

  public function getSpeedAdjustment() {
    return $this->speed_adjustment;
  }

  public function getRoom() {
    return $this->room;
  }

  public function getDataEntryRepository() {
    return $this->_data_entry_repository;
  }

  public function getTranslator() {
    return $this->_translator;
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

  public function setDataEntryRepository($value) {
    $this->_data_entry_repository = $value;
    return $this;
  }

  public function setTranslator($value) {
    $this->_translator = $value;
    return $this;
  }

}