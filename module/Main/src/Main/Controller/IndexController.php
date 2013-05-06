<?php

namespace Main\Controller;
use Main\Entity\UserRole;

class IndexController extends ApplicationController {
  public function indexAction() {
    $user = $this->getIdentity();
    if ($user->hasRole(UserRole::ROLE_ADMIN)) {
      return $this->redirect()->toRoute('configuration');
    } else {
      return $this->redirect()->toRoute('mobile');
    };
  }
}
