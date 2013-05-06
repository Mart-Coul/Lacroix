<?php

namespace Lacroix\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class User extends Form {
  public function __construct($t, $em) {
    parent::__construct('user');

    $factory = new \Zend\InputFilter\Factory();
    $this
      ->setAttribute('method', 'post')
      ->setInputFilter($factory->createInputFilter($this->getInputFilterSpecification()));

    // ---

    $name = new \Zend\Form\Element\Text('name');
    $name->setLabel($t->translate('Username'));

    $password = new \Zend\Form\Element\Password('password');
    $password->setLabel($t->translate('Password'));

    $admin = new \Zend\Form\Element\Checkbox('admin');
    $admin->setLabel($t->translate('Is admin'));

    $production = new \Zend\Form\Element\Checkbox('production');
    $production->setLabel($t->translate('Is production staff'));

    // ---

    $csrf = new \Zend\Form\Element\Csrf('security');

    $ok = new \Zend\Form\Element\Submit('save');
    $ok->setValue($t->translate('Save'));

    // ---

    $this->add($name);
    $this->add($password);

    $this->add($admin);
    $this->add($production);

    $this->add($csrf);
    $this->add($ok);
  }

  public function getInputFilterSpecification() {
    return array('name' => array('required' => true),
                 'password' => array('required' => false),
                 'admin' => array('required' => false),
                 'prodution' => array('required' => false));
  }

  public function createEntity($em) {
    return $this->updateEntity($em, new \Main\Entity\User());
  }

  public function updateEntity($em, \Main\Entity\User $item) {
    $data = $this->getData();

    if ($data['password']) {
      $item->setPassword($data['password']);
    };

    $item
      ->setEmail($data['name']);

    $item->toggleRole($em, \Main\Entity\UserRole::ROLE_ADMIN, $data['admin']);
    $item->toggleRole($em, \Main\Entity\UserRole::ROLE_PRODUCTION, $data['production']);

    return $item;
  }

  public function loadEntity(\Main\Entity\User $item) {
    $this->setData(array('name' => $item->getEmail(),
                         'admin' => $item->hasRole(\Main\Entity\UserRole::ROLE_ADMIN),
                         'production' => $item->hasRole(\Main\Entity\UserRole::ROLE_PRODUCTION)));

    return $this;
  }
}