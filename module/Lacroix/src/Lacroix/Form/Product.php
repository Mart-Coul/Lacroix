<?php

namespace Lacroix\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class Product extends Form {
  public function __construct($t, $em) {
    parent::__construct('product');

    $factory = new \Zend\InputFilter\Factory();
    $this
      ->setAttribute('method', 'post')
      ->setInputFilter($factory->createInputFilter($this->getInputFilterSpecification()));

    // ---

    $name = new \Zend\Form\Element\Text('name');
    $name->setLabel($t->translate('Name'));

    $target_productivity = new \Zend\Form\Element\Text('target_productivity');
    $target_productivity->setLabel($t->translate('Target productivity'));

    // ---

    $csrf = new \Zend\Form\Element\Csrf('security');

    $ok = new \Zend\Form\Element\Submit('save');
    $ok->setValue($t->translate('Save'));

    // ---

    $this->add($name);
    $this->add($target_productivity);

    $this->add($csrf);
    $this->add($ok);
  }

  public function getInputFilterSpecification() {
    return array('name' => array('required' => true),
                 'target_productivity' => array('required' => true,
                                                'validators' => array(array('name' => 'Int'),
                                                                      array('name' => 'Between',
                                                                            'min' => 0,
                                                                            'max' => 9999))));
  }

  public function createEntity($em) {
    return $this->updateEntity($em, new \Lacroix\Entity\Product());
  }

  public function updateEntity($em, \Lacroix\Entity\Product $item) {
    $data = $this->getData();

    return $item
      ->setName($data['name'])
      ->setTargetProductivity($data['target_productivity']);
  }

  public function loadEntity(\Lacroix\Entity\Product $item) {
    $this->setData(array('name' => $item->getName(),
                         'target_productivity' => $item->getTargetProductivity()));

    return $this;
  }
}