<?php

namespace Main\Controller;

abstract class RestController extends ApplicationController {
  public function indexAction() {
    return array('items' => $this->getDefaultRepository()->findAll());
  }

  abstract protected function getDefaultRepository();
}