<?php

namespace Main;

use DoctrineModule\Authentication\Storage\ObjectRepository as DoctrineStorage;

class AuthStorage extends DoctrineStorage {
  public function setRememberMe($rememberMe = 0, $time = 1209600) {
    if ($rememberMe == 1) {
      $container = new \Zend\Session\Container(__NAMESPACE__);
      $container->getManager()->rememberMe($time);
    }
  }
    
  public function forgetMe() {
    $container = new \Zend\Session\Container(__NAMESPACE__);
    $container->getManager()->forgetMe();
  } 
}