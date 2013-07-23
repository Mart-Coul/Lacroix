<?php

namespace Lacroix\Controller;
use \Main\Controller\ApplicationController;

class DataEntriesController extends LacroixController {
  
  protected function getDefaultRepository() {
    return $this->getEntityManager()->getRepository('Lacroix\Entity\DataEntry');
  }
  
  public function indexView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('Data'),
                                  $data,
                                  'data-entries',
                                  'lacroix/data-entries/index');
  }
  
  public function editView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('Edit data'),
                                  $data,
                                  'data-entries',
                                  'lacroix/data-entries/edit');
  }
  
  public function getEditForm($item) {
    $form = new \Lacroix\Form\Reading($this->getTranslator(),
                                             $this->getEntityManager(),
                                             true);
    $form->setAttribute('action', 
                        $this->url()->fromRoute('readings/update', 
                                                array('id' => $item->getId()))); 
    return $form;
  }

  
  public function deleteView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('Delete data'),
                                  $data,
                                  'data-entries',
                                  'lacroix/data-entries/delete');
  }

  public function getDeleteForm($item) {
    $form = new \Main\Form\GenericDelete($this->getTranslator());
    $form->setAttribute('action', 
                        $this->url()->fromRoute('data-entries/confirm-delete', 
                                                array('id' => $item->getId()))); 
    return $form;
  }
  
  public function redirectToHome() {
    return $this->redirect()->toRoute('data-entries');
  }
}
