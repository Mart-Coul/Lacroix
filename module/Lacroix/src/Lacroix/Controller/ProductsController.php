<?php

namespace Lacroix\Controller;

class ProductsController extends LacroixController {
  protected function getDefaultRepository() {
    return $this->getEntityManager()->getRepository('Lacroix\Entity\Product');
  }

  public function indexView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('Products'),
                                  $data,
                                  'products',
                                  'lacroix/products/index');
  }

  public function newView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('New product'),
                                  $data,
                                  'products',
                                  'lacroix/products/new');
  }

  public function editView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('Edit product'),
                                  $data,
                                  'products',
                                  'lacroix/products/edit');
  }

  public function deleteView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('Delete product'),
                                  $data,
                                  'products',
                                  'lacroix/products/delete');
  }

  public function getNewForm() {
    $form = new \Lacroix\Form\Product($this->getTranslator(),
                                      $this->getEntityManager());
    $form->setAttribute('action', 
                        $this->url()->fromRoute('products/create')); 
    return $form;
  }

  public function getEditForm($item) {
    $form = new \Lacroix\Form\Product($this->getTranslator(),
                                      $this->getEntityManager());
    $form->setAttribute('action', 
                        $this->url()->fromRoute('products/update', 
                                                array('id' => $item->getId()))); 
    return $form;
  }

  public function getDeleteForm($item) {
    $form = new \Main\Form\GenericDelete($this->getTranslator());
    $form->setAttribute('action', 
                        $this->url()->fromRoute('products/confirm-delete', 
                                                array('id' => $item->getId()))); 
    return $form;
  }

  public function redirectToHome() {
    return $this->redirect()->toRoute('products');
  }
}
