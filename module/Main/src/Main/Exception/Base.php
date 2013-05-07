<?php

namespace Main\Exception;

abstract class Base extends \Exception {
  public function toResponse() {
    return array();
  }
}