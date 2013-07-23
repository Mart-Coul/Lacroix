<?php

namespace Lacroix\Form;

use Zend\Form\Form;

class Reading extends Form {
  public function __construct($t, $em, $fullForm = false) {
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
    
    $teamLeader = new \Zend\Form\Element\Select('team_leader');
    $teamLeader->setLabel($t->translate('Team leader'));

 	$options = array('' => '');
    foreach ($em->getRepository('Lacroix\Entity\TeamLeader')->findAll() as $item) {
      $options[$item->getId()] = $item->getName();
    };
    $teamLeader->setValueOptions($options);
    // ---

    // ---

    $this->add($product);
    $this->add($reading);
    $this->add($employees);
    $this->add($notes);
    $this->add($teamLeader);
    
    if ($fullForm) {
    
      $line = new \Zend\Form\Element\Hidden('line');
    
      $csrf = new \Zend\Form\Element\Csrf('security');

      $ok = new \Zend\Form\Element\Submit('save');
      $ok->setValue($t->translate('Save'));

	  $this->add($line);
	  $this->add($csrf);
      $this->add($ok);
    }
  }
  
  public function updateEntity($em, \Lacroix\Entity\DataEntry $item) {
    $data = $this->getData();

    $productionLine = $em->getRepository('Lacroix\Entity\ProductionLine')->find($data['line']);
    $product = $em->getRepository('Lacroix\Entity\Product')->find($data['product_id']);
    $teamLeader = $em->getRepository('Lacroix\Entity\TeamLeader')->find($data['team_leader']);

    return $item
      ->setProductionLine($productionLine)
      ->setProduct($product)
      ->setEmployees($data['employees'])
      ->setReading($data['reading'])
      ->setNotes($data['notes'])
      ->setTeamLeader($teamLeader);
  }

  public function loadEntity(\Lacroix\Entity\DataEntry $item) {
    $this->setData(array('employees' => $item->getEmployees(),
    					 'reading'   => $item->getReading(),
    					 'notes' 	 => $item->getNotes(),
    					 'team_leader' => $item->getTeamLeader(),
    					 'product_id' 	 => $item->getProduct()->getId(),
    					 'line' 	 => $item->getProductionLine()->getId()));


	
    return $this;
  }
  
  
   
}