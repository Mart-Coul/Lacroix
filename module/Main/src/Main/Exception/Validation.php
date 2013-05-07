<?php

namespace Main\Exception;

class Validation extends Base {
  private $_validator;

  function __construct($validator) {
    $this->_validator = $validator;

    parent::__construct('Validation error');
  }

  public function toResponse() {
    return array('errors' => $this->_validator->getMessages());
  }
}