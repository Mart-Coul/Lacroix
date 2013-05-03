<?php

namespace Main\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

abstract class ApplicationController extends AbstractActionController {
  public $default_layout = null;

  private $auth_service;

  public function maybeJson($data) {
    if ($this->isAjax()) {
      return new JsonModel($data);
    } else {
      return new ViewModel($data);
    };
  }

  protected function isAjax() {
    $h = $this->getRequest()->getHeaders()->get('X-Requested-With');
    if (!$h) { 
      return false;
    };

    return $h->getFieldValue() == 'XMLHttpRequest';
  }

  protected function getAuthService() {
    if (! $this->auth_service) {
      $this->auth_service = $this->getServiceLocator()->get('AuthService');
    };
    
    return $this->auth_service;  
  }

  protected function getEntityManager() {
    if (is_null($this->_em)) {
      $this->_em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
    };

    return $this->_em;
  }

  protected function getTranslator() {
    return $this->getServiceLocator()->get('translator');
  }
}

?>