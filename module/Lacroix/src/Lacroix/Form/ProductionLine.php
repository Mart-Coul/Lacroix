<?php

namespace Lacroix\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class ProductionLine extends Form {
  public function __construct($t, $em) {
    parent::__construct('production-line');

    $factory = new \Zend\InputFilter\Factory();
    $this
      ->setAttribute('method', 'post')
      ->setInputFilter($factory->createInputFilter($this->getInputFilterSpecification()));

    // ---

    $name = new \Zend\Form\Element\Text('name');
    $name->setLabel($t->translate('Name'));

    $speed_adjustment = new \Zend\Form\Element\Text('speed_adjustment');
    $speed_adjustment->setLabel($t->translate('Speed adjustment'));

    $room = new \Zend\Form\Element\Select('room');
    $room->setLabel($t->translate('Room'));

    $options = array();
    foreach ($em->getRepository('Lacroix\Entity\Room')->findAll() as $item) {
      $options[$item->getId()] = $item->getName();
    };
    $room->setValueOptions($options);

    $leader = new \Zend\Form\Element\Select('team_leader');
    $leader->setLabel($t->translate('Team Leader'));

    $options = array('' => '');
    foreach ($em->getRepository('Main\Entity\User')->findAll() as $item) {
      $options[$item->getId()] = $item->getFullName();
    };
    $leader->setValueOptions($options);

    // ---

    $csrf = new \Zend\Form\Element\Csrf('security');

    $ok = new \Zend\Form\Element\Submit('save');
    $ok->setValue($t->translate('Save'));

    // ---

    $this->add($name);
    $this->add($speed_adjustment);
    $this->add($room);
    $this->add($leader);

    $this->add($csrf);
    $this->add($ok);
  }

  public function getInputFilterSpecification() {
    return array('name' => array('required' => true),
                 'speed_adjustment' => array('required' => true,
                                             'validators' => array(array('name' => 'Float'),
                                                                   array('name' => 'Between',
                                                                         'min' => 0,
                                                                         'max' => 9999))),
                 'room' => array('required' => true));
  }

  public function createEntity($em) {
    return $this->updateEntity($em, new \Lacroix\Entity\ProductionLine());
  }

  public function updateEntity($em, \Lacroix\Entity\ProductionLine $item) {
    $data = $this->getData();

    $room = $em->getRepository('Lacroix\Entity\Room')->find($data['room']);
    $team_leader = $em->getRepository('Main\Entity\User')->find($data['team_leader']);

    return $item
      ->setName($data['name'])
      ->setSpeedAdjustment($data['speed_adjustment'])
      ->setRoom($room)
      ->setTeamLeader($team_leader);
  }

  public function loadEntity(\Lacroix\Entity\ProductionLine $item) {
    $this->setData(array('name' => $item->getName(),
                         'speed_adjustment' => $item->getSpeedAdjustment(),
                         'room' => $item->getRoom()->getId(),
                         'team_leader' => $item->getTeamLeaderId()));

    return $this;
  }
}