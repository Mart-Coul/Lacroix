<?php

namespace Lacroix\Controller;

class UsersController extends LacroixController {
  protected function getDefaultRepository() {
    return $this->getEntityManager()->getRepository('Main\Entity\User');
  }

  public function indexView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('Users'),
                                  $data,
                                  'users',
                                  'lacroix/users/index');
  }

  public function newView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('New user'),
                                  $data,
                                  'admin-users',
                                  'lacroix/admin-users/new');
  }

  public function editView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('Edit user'),
                                  $data,
                                  'admin-users',
                                  'lacroix/admin-users/edit');
  }

  public function deleteView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('Delete user'),
                                  $data,
                                  'admin-users',
                                  'lacroix/admin-users/delete');
  }

  public function getNewForm() {
    $form = new \Lacroix\Form\User($this->getTranslator(),
                                   $this->getEntityManager());
    $form->setAttribute('action', 
                        $this->url()->fromRoute('admin-users/create')); 
    return $form;
  }

  public function getEditForm($item) {
    $form = new \Lacroix\Form\User($this->getTranslator(),
                                   $this->getEntityManager());
    $form->setAttribute('action', 
                        $this->url()->fromRoute('admin-users/update', 
                                                array('id' => $item->getId()))); 
    return $form;
  }

  public function getDeleteForm($item) {
    $form = new \Main\Form\GenericDelete($this->getTranslator());
    $form->setAttribute('action', 
                        $this->url()->fromRoute('admin-users/confirm-delete', 
                                                array('id' => $item->getId()))); 
    return $form;
  }

  public function redirectToHome() {
    return $this->redirect()->toRoute('admin-users');
  }
}
