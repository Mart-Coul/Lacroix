<?php

namespace Main\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class GenericDelete extends Form  {
  public function __construct($t) {
    parent::__construct('generic-delete');

    $factory = new \Zend\InputFilter\Factory();
    $this->setInputFilter($factory->createInputFilter($this->getInputFilterSpecification()))
      ->setAttribute('method', 'post');

    // ---

    // ---

    $csrf = new Element\Csrf('security');

    $ok = new Element\Submit('ok');
    $ok->setValue($t->translate('Delete'));

    // ---

    $this->add($csrf);
    $this->add($ok);
  }

  public function getInputFilterSpecification() {
    return array();
  }
}

?>