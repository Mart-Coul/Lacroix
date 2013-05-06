<?php

namespace Lacroix\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class Room extends Form {
  public function __construct($t, $em) {
    parent::__construct('product');

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
    return array('name' => array('required' => true));
  }

  public function createEntity($em) {
    return $this->updateEntity($em, new \Lacroix\Entity\Room());
  }

  public function updateEntity($em, \Lacroix\Entity\Room $item) {
    $data = $this->getData();

    return $item
      ->setName($data['name']);
  }

  public function loadEntity(\Lacroix\Entity\Room $item) {
    $this->setData(array('name' => $item->getName()));

    return $this;
  }
}