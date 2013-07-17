<?php

namespace Lacroix\Form;

use Zend\Form\Form;

class Reading extends Form {
  public function __construct($t, $em) {
    parent::__construct('reading');

    // ---

    $product = new \Zend\Form\Element\Select('product_id');
    $product->setLabel($t->translate('Product'));

    $options = array('' => '');
    foreach ($em->getRepository('Lacroix\Entity\Product')->findAll() as $item) {
      $options[$item->getId()] = $item->getName();
    };
    $product
      ->setValueOptions($options);

    $reading = new \Zend\Form\Element\Text('reading');
    $reading->setLabel($t->translate('Reading'));

    $employees = new \Zend\Form\Element\Text('employees');
    $employees->setLabel($t->translate('Employees'));

    $notes = new \Zend\Form\Element\Select('notes');
    $notes->setLabel($t->translate('Notes'));
    
    $options = array('' => '');
    foreach ($em->getRepository('Lacroix\Entity\NoteTemplate')->findAll() as $item) {
      $options[$item->getContent()] = $item->getContent();
    };
    $notes->setValueOptions($options);
    
    $teamLeader = new \Zend\Form\Element\Text('team_leader');
    $teamLeader->setLabel($t->translate('Team leader'));

    // ---

    // ---

    $this->add($product);
    $this->add($reading);
    $this->add($employees);
    $this->add($notes);
    $this->add($teamLeader);
  }
}