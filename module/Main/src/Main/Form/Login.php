<?php

namespace Main\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class Login extends Form  {
  public function __construct($t) {
    parent::__construct('login');

    $factory = new \Zend\InputFilter\Factory();

    $this->setInputFilter($factory->createInputFilter($this->getInputFilterSpecification()))
      ->setAttribute('method', 'post');

    // ---

    $login = new Element\Text('login');
    $login->setLabel($t->translate('Your username'));

    $password = new Element\Password('password');
    $password->setLabel($t->translate('Your password'));

    $remember = new Element\Checkbox('remember');
    $remember->setLabel($t->translate('Remember me'));

    // ---

    $csrf = new Element\Csrf('security');

    $ok = new Element\Submit('ok');
    $ok->setValue($t->translate('Login'));

    // ---

    $this->add($login);
    $this->add($password);
    $this->add($remember);

    $this->add($csrf);
    $this->add($ok);
  }

  public function getInputFilterSpecification() {
    return array('login' => array('required' => true),
                 'password' => array('required' => true));
  }
}

?>