<?php

namespace Lacroix\Controller;

class ProductionLinesController extends LacroixController {
  protected function getDefaultRepository() {
    return $this->getEntityManager()->getRepository('Lacroix\Entity\ProductionLine');
  }

  public function indexView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('Production lines'),
                                  $data,
                                  'production-lines',
                                  'lacroix/production-lines/index');
  }

  public function newView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('New production line'),
                                  $data,
                                  'production-lines',
                                  'lacroix/production-lines/new');
  }

  public function editView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('Edit production line'),
                                  $data,
                                  'production-lines',
                                  'lacroix/production-lines/edit');
  }

  public function deleteView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('Delete production line'),
                                  $data,
                                  'production-lines',
                                  'lacroix/production-lines/delete');
  }

  public function getNewForm() {
    $form = new \Lacroix\Form\ProductionLine($this->getTranslator(),
                                             $this->getEntityManager());
    $form->setAttribute('action', 
                        $this->url()->fromRoute('production-lines/create')); 
    return $form;
  }

  public function getEditForm($item) {
    $form = new \Lacroix\Form\ProductionLine($this->getTranslator(),
                                             $this->getEntityManager());
    $form->setAttribute('action', 
                        $this->url()->fromRoute('production-lines/update', 
                                                array('id' => $item->getId()))); 
    return $form;
  }

  public function getDeleteForm($item) {
    $form = new \Main\Form\GenericDelete($this->getTranslator());
    $form->setAttribute('action', 
                        $this->url()->fromRoute('production-lines/confirm-delete', 
                                                array('id' => $item->getId()))); 
    return $form;
  }

  public function redirectToHome() {
    return $this->redirect()->toRoute('production-lines');
  }
}
