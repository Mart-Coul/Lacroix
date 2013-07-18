<?php

namespace Lacroix\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class TeamLeader extends Form {
  public function __construct($t, $em) {
    parent::__construct('team-leader');

    $factory = new \Zend\InputFilter\Factory();
    $this
      ->setAttribute('method', 'post')
      ->setInputFilter($factory->createInputFilter($this->getInputFilterSpecification()));

    // ---

    $name = new \Zend\Form\Element\Text('name');
    $name->setLabel($t->translate('Name'));

    // ---

    $csrf = new \Zend\Form\Element\Csrf('security');

    $ok = new \Zend\Form\Element\Submit('save');
    $ok->setValue($t->translate('Save'));

    // ---

    $this->add($name);

    $this->add($csrf);
    $this->add($ok);
  }

  public function getInputFilterSpecification() {
    return array('name' => array('required' => true),

                 );
  }

  public function createEntity($em) {
    return $this->updateEntity($em, new \Lacroix\Entity\TeamLeader());
  }

  public function updateEntity($em, \Lacroix\Entity\TeamLeader $item) {
    $data = $this->getData();

    return $item
      ->setName($data['name']);
  }

  public function loadEntity(\Lacroix\Entity\TeamLeader $item) {
    $this->setData(array('name' => $item->getName(),));

    return $this;
  }
}