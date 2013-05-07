<?php

namespace Main\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

abstract class ApplicationController extends AbstractActionController {
  public $default_layout = null;

  private $auth_service;
  private $_em;

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

  protected function validateAjaxGet($data, $context = array()) {
    foreach ($data as $pair) {
      list($value, $validator) = $pair;
      
      if (!$validator->isValid($value, $context)) {
        throw new \Main\Exception\Validation($validator);
      };
    };
  }

  protected function validateAjaxCall($data, $context = array()) {
    if (!$this->getRequest()->isPost()) {
      throw new \Main\Exception\InvalidMethod();
    };

    $this->validateAjaxGet($data, $context);
  }

  protected function jsonError($data = null) {
    return new JsonModel(array('success' => false,
                               'data' => $data));
  }

  protected function jsonSuccess($data = null) {
    return new JsonModel(array('success' => true,
                               'data' => $data));
  }

  protected function getAuthService() {
    if (! $this->auth_service) {
      $this->auth_service = $this->getServiceLocator()->get('AuthService');
    };
    
    return $this->auth_service;  
  }

  protected function getIdentity() {
    return $this->getAuthService()->getIdentity();
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