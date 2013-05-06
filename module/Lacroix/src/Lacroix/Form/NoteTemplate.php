<?php

namespace Lacroix\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class NoteTemplate extends Form {
  public function __construct($t, $em) {
    parent::__construct('product');

    $factory = new \Zend\InputFilter\Factory();
    $this
      ->setAttribute('method', 'post')
      ->setInputFilter($factory->createInputFilter($this->getInputFilterSpecification()));

    // ---

    $content = new \Zend\Form\Element\Textarea('content');
    $content->setLabel($t->translate('Content'));

    // ---

    $csrf = new \Zend\Form\Element\Csrf('security');

    $ok = new \Zend\Form\Element\Submit('save');
    $ok->setValue($t->translate('Save'));

    // ---

    $this->add($content);

    $this->add($csrf);
    $this->add($ok);
  }

  public function getInputFilterSpecification() {
    return array('content' => array('required' => true));
  }

  public function createEntity($em) {
    return $this->updateEntity($em, new \Lacroix\Entity\NoteTemplate());
  }

  public function updateEntity($em, \Lacroix\Entity\NoteTemplate $item) {
    $data = $this->getData();

    return $item
      ->setContent($data['content']);
  }

  public function loadEntity(\Lacroix\Entity\NoteTemplate $item) {
    $this->setData(array('content' => $item->getContent()));

    return $this;
  }
}