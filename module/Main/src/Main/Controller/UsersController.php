<?php

namespace Main\Controller;

class UsersController extends ApplicationController {
  public function loginAction() {
    $user = $this->getAuthService()->getIdentity();
  
    return array('form' => $this->getLoginForm(),
                 'messages' => $this->flashMessenger()->getMessages());
  }

  public function authenticateAction() {
    $request = $this->getRequest();

    // Contract

    if (!$request->isPost()) {
      return $this->redirect()->toRoute('users/login');
    };

    $form = $this->getLoginForm();
    $form->setData($request->getPost());
    if (!$form->isValid()) {
      return $this->redirect()->toRoute('users/login');
    };

    $input = $form->getInputFilter();

    // Action

    $this->getAuthService()->getAdapter()
      ->setIdentityValue($input->getValue('login'))
      ->setCredentialValue($input->getValue('password'));

    $result = $this->getAuthService()->authenticate();
    foreach ($result->getMessages() as $message) {
      $this->flashmessenger()->addMessage($message);
    };

    if (!$result->isValid()) {
      return $this->redirect()->toRoute('users/login');
    };

    if ($request->getPost('remember')) {
      $this->getSessionStorage()->setRememberMe(1);
    };
	
    return $this->redirect()->toRoute('home');
  }

  public function logoutAction() {
    $this->getSessionStorage()->forgetMe();
    $this->getAuthService()->clearIdentity();
    $this->flashMessenger()->addMessage($this->getTranslator()->translate('You\'ve been logged out'));
    return $this->redirect()->toRoute('users/login');
  }

  /*
   * Implementation details
   */

  protected function getLoginForm() {
    return new \Main\Form\Login($this->getTranslator());
  }

  protected function getSessionStorage() {
    if (!isset($this->_storage)) {
      $this->_storage = $this->getServiceLocator()->get('AuthStorage');
    }
    
    return $this->_storage;  
  }
}

?>