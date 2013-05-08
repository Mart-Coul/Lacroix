<?php

namespace Lacroix\Controller;
use \Zend\View\Model\ViewModel;
use \Main\Controller\ApplicationController;

class MobileController extends ApplicationController {
  public $default_layout = 'layout/mobile';

  public function indexAction() {
    $view = new ViewModel(array('lines' => $this->getEntityManager()->getRepository('Lacroix\Entity\ProductionLine')->findAll(),
                                'reading_form' => $this->getReadingForm()));
    return $view;
  }

  public function roomAction() {
    $room_id = (int)$this->params('room_id');
    $room = $this->getEntityManager()->getRepository('Lacroix\Entity\Room')->find($room_id);

    $view = new ViewModel(array('lines' => $room->getProductionLines(),
                                'reading_form' => $this->getReadingForm()));
    $view->setTemplate('lacroix/mobile/index');
    return $view;
  }

  public function addReadingAction() {
    $em = $this->getEntityManager();
    $line_repo = $em->getRepository('Lacroix\Entity\ProductionLine');
    $product_repo = $em->getRepository('Lacroix\Entity\Product');

    $line_id = (int)$this->params('line_id');
    $reading = (float)$this->params()->fromPost('reading');
    $employees = (int)$this->params()->fromPost('employees');
    $notes = (string)$this->params()->fromPost('notes');
    $product_id = (int)$this->params()->fromPost('product_id');

    // Contract

    $line_id_validator = new \Zend\Validator\ValidatorChain();
    $line_id_validator->attach(new \DoctrineModule\Validator\ObjectExists(array('object_repository' => $line_repo,
                                                                                'fields' => 'id')));

    $product_id_validator = new \Zend\Validator\ValidatorChain();
    $product_id_validator->attach(new \DoctrineModule\Validator\ObjectExists(array('object_repository' => $product_repo,
                                                                                   'fields' => 'id')));

    $reading_validator = new \Zend\Validator\ValidatorChain();
    $reading_validator->attach(new \Zend\Validator\Between(array('min' => 0,
                                                                 'max' => 9999)));

    $employees_validator = new \Zend\Validator\ValidatorChain();
    $employees_validator->attach(new \Zend\Validator\Between(array('min' => 0,
                                                                   'max' => 9999)));

    $this->validateAjaxCall(array(array($line_id, $line_id_validator),
                                  array($reading, $reading_validator),
                                  array($employees, $employees_validator),
                                  array($product_id, $product_id_validator)));

    // Action
    
    $line = $line_repo->find($line_id);
    $product = $product_repo->find($product_id);

    $entry = new \Lacroix\Entity\DataEntry();
    $entry
      ->setProductionLine($line)
      ->setProduct($product)
      ->setEmployees($employees)
      ->setReading($reading)
      ->setNotes($notes);

    $em->persist($entry);
    $em->flush();
    
    return $this->jsonSuccess();
  }

  protected function getReadingForm() {
    return new \Lacroix\Form\Reading($this->getTranslator(),
                                     $this->getEntityManager());
  }
}
