<?php

namespace Main\Controller;
use \Zend\View\Model\ViewModel;

abstract class RestController extends ApplicationController {
  public function indexAction() {
    return $this->indexView(array('items' => $this->getDefaultRepository()->findAll()));
  }

  public function newAction() {
    return $this->newView(array('form' => $this->getNewForm()));
  }

  public function createAction() {
    $em = $this->getEntityManager();

    // Contract 

    if (!$this->getRequest()->isPost()) {
      return $this->redirectToHome();
    };

    $form = $this->getNewForm();
    $form->setData($this->getRequest()->getPost());

    if (!$form->isValid()) {
      return $this->newView(array('form' => $form));
    };

    // Action
    $item = $form->createEntity($this->getEntityManager());
    $em->persist($item);
    $em->flush();

    return $this->redirectToHome();
  }

  public function editAction() {
    $request = $this->getRequest();

    // Contract

    $item = $this->getDefaultRepository()->find((int)$this->params('id'));

    if (!$item) {
      return $this->redirectToHome();
    };

    // Action

    $form = $this->getEditForm($item);
    $form->loadEntity($item, 
                      $request->getQuery()->toArray());

    return $this->editView(array('form' => $form,
                                 'item' => $item));
  }

  public function updateAction() {
    $em = $this->getEntityManager();
    $request = $this->getRequest();

    // Contract
    
    if (!$this->getRequest()->isPost()) {
      return $this->redirectToHome();
    };

    $id = (int)$this->params('id');
    $item = $this->getDefaultRepository()->find($id);
    if (!$item) {
      return $this->redirect()->toUrl('return');
    };

    $form = $this->getEditForm($item);
    $form->setData($request->getPost());

    if (!$form->isValid()) {
      return $this->editView(array('form' => $form,
                                   'item' => $item));
    };

    // Action

    $form->updateEntity($em, $item);
    $em->flush();

    return $this->redirectToHome();
  }

  public function deleteAction() {
    // Contract
    $item = $this->getDefaultRepository()->find($this->params('id'));
    if (!$item) {
      return $this->redirectToHome();
    };

    // Action

    $form = $this->getDeleteForm($item);
    return $this->deleteView(array('form' => $form));
  }

  public function confirmDeleteAction() {
    $em = $this->getEntityManager();

    // Contract 

    if (!$this->getRequest()->isPost()) {
      return $this->redirectToHome();
    };

    $item = $this->getDefaultRepository()->find($this->params('id'));
    if (!$item) {
      return $this->redirectToHome();
    };

    // Action

    $em->remove($item);
    $em->flush();

    return $this->redirectToHome();
  }

  public function indexView($data) {
    return new ViewModel($data);
  }

  public function newView($data) {
    return new ViewModel($data);
  }

  public function editView($data) {
    return new ViewModel($data);
  }

  public function deleteView($data) {
    return new ViewModel($data);
  }

  public function redirectToHome() {
    return $this->redirect()->toRoute('home');
  }

  abstract protected function getDefaultRepository();
  abstract protected function getNewForm();
  abstract protected function getEditForm($item);
  abstract protected function getDeleteForm($item);

}