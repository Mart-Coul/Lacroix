<?php

namespace Lacroix\Controller;

class NoteTemplatesController extends LacroixController {
  protected function getDefaultRepository() {
    return $this->getEntityManager()->getRepository('Lacroix\Entity\NoteTemplate');
  }

  public function indexView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('Generic comments'),
                                  $data,
                                  'note-templates',
                                  'lacroix/note-templates/index');
  }

  public function newView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('New comment'),
                                  $data,
                                  'note-templates',
                                  'lacroix/note-templates/new');
  }

  public function editView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('Edit comment'),
                                  $data,
                                  'note-templates',
                                  'lacroix/note-templates/edit');
  }

  public function deleteView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('Delete comment'),
                                  $data,
                                  'note-templates',
                                  'lacroix/note-templates/delete');
  }

  public function getNewForm() {
    $form = new \Lacroix\Form\NoteTemplate($this->getTranslator(),
                                           $this->getEntityManager());
    $form->setAttribute('action', 
                        $this->url()->fromRoute('note-templates/create')); 
    return $form;
  }

  public function getEditForm($item) {
    $form = new \Lacroix\Form\NoteTemplate($this->getTranslator(),
                                           $this->getEntityManager());
    $form->setAttribute('action', 
                        $this->url()->fromRoute('note-templates/update', 
                                                array('id' => $item->getId()))); 
    return $form;
  }

  public function getDeleteForm($item) {
    $form = new \Main\Form\GenericDelete($this->getTranslator());
    $form->setAttribute('action', 
                        $this->url()->fromRoute('note-templates/confirm-delete', 
                                                array('id' => $item->getId()))); 
    return $form;
  }

  public function redirectToHome() {
    return $this->redirect()->toRoute('note-templates');
  }
}
