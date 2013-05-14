<?php

namespace Lacroix\Controller;
use \Zend\View\Model\ViewModel;
use \Main\Controller\ApplicationController;

class StatisticsController extends ApplicationController {
  public function indexAction() {
    $view = new ViewModel(array('lines' => $this->getEntityManager()->getRepository('Lacroix\Entity\ProductionLine')->findAll()));
    return $view;
  }
}
