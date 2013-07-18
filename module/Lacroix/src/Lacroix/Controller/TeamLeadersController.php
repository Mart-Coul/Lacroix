<?php

namespace Lacroix\Controller;

class TeamLeadersController extends LacroixController {
  protected function getDefaultRepository() {
    return $this->getEntityManager()->getRepository('Lacroix\Entity\TeamLeader');
  }

  public function indexView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('Team Leaders'),
                                  $data,
                                  'team-leaders',
                                  'lacroix/team-leaders/index');
  }

  public function newView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('New team leader'),
                                  $data,
                                  'team-leaders',
                                  'lacroix/team-leaders/new');
  }

  public function editView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('Edit team leader'),
                                  $data,
                                  'team-leaders',
                                  'lacroix/team-leaders/edit');
  }

  public function deleteView($data) {
    return $this->viewWithSidebar($this->getTranslator()->translate('Delete team leader'),
                                  $data,
                                  'team-leaders',
                                  'lacroix/team-leaders/delete');
  }

  public function getNewForm() {
    $form = new \Lacroix\Form\TeamLeader($this->getTranslator(),
                                      $this->getEntityManager());
    $form->setAttribute('action', 
                        $this->url()->fromRoute('team-leaders/create')); 
    return $form;
  }

  public function getEditForm($item) {
    $form = new \Lacroix\Form\TeamLeader($this->getTranslator(),
                                      $this->getEntityManager());
    $form->setAttribute('action', 
                        $this->url()->fromRoute('team-leaders/update', 
                                                array('id' => $item->getId()))); 
    return $form;
  }

  public function getDeleteForm($item) {
    $form = new \Main\Form\GenericDelete($this->getTranslator());
    $form->setAttribute('action', 
                        $this->url()->fromRoute('team-leaders/confirm-delete', 
                                                array('id' => $item->getId()))); 
    return $form;
  }

  public function redirectToHome() {
    return $this->redirect()->toRoute('team-leaders');
  }
}
