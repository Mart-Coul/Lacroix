<?php

namespace Lacroix\Controller;

class RoomsController extends LacroixController {
  protected function getDefaultRepository() {
    return $this->getEntityManager()->getRepository('Lacroix\Entity\Room');
  }

  public function indexView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('Rooms'),
                                  $data,
                                  'rooms',
                                  'lacroix/rooms/index');
  }

  public function newView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('New room'),
                                  $data,
                                  'rooms',
                                  'lacroix/rooms/new');
  }

  public function editView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('Edit room'),
                                  $data,
                                  'rooms',
                                  'lacroix/rooms/edit');
  }

  public function deleteView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('Delete room'),
                                  $data,
                                  'rooms',
                                  'lacroix/rooms/delete');
  }

  public function getNewForm() {
    $form = new \Lacroix\Form\Room($this->getTranslator(),
                                   $this->getEntityManager());
    $form->setAttribute('action', 
                        $this->url()->fromRoute('rooms/create')); 
    return $form;
  }

  public function getEditForm($item) {
    $form = new \Lacroix\Form\Room($this->getTranslator(),
                                   $this->getEntityManager());
    $form->setAttribute('action', 
                        $this->url()->fromRoute('rooms/update', 
                                                array('id' => $item->getId()))); 
    return $form;
  }

  public function getDeleteForm($item) {
    $form = new \Main\Form\GenericDelete($this->getTranslator());
    $form->setAttribute('action', 
                        $this->url()->fromRoute('rooms/confirm-delete', 
                                                array('id' => $item->getId()))); 
    return $form;
  }

  public function redirectToHome() {
    return $this->redirect()->toRoute('rooms');
  }
}
