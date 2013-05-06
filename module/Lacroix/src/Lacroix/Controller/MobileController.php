<?php

namespace Lacroix\Controller;
use \Zend\View\Model\ViewModel;
use \Main\Controller\ApplicationController;

class MobileController extends ApplicationController {
  public function indexAction() {
    $view = new ViewModel(array('lines' => $this->getEntityManager()->getRepository('Lacroix\Entity\ProductionLine')->findAll()));
    return $view;
  }

  public function roomAction() {
    $room_id = (int)$this->params('room_id');
    $room = $this->getEntityManager()->getRepository('Lacroix\Entity\Room')->find($room_id);

    $view = new ViewModel(array('lines' => $room->getProductionLines()));
    $view->setTemplate('lacroix/mobile/index');
    return $view;
  }
}
