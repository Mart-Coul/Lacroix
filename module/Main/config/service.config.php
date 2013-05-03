<?php

namespace Main;

use Zend\Authentication\AuthenticationService;

use DoctrineModule\Authentication\Adapter\ObjectRepository as AuthAdapter;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole;
use Zend\Permissions\Acl\Resource\GenericResource;

return 

array(
  'factories' => array(
    'AuthService' => function($sm) {
      $options = array(
        'objectManager' => $sm->get('doctrine.entitymanager.orm_default'),
        'identityClass' => 'Main\Entity\User',
        'identityProperty' => 'email',
        'credentialProperty' => 'password',
        'credentialCallable' => function($identity, $password) {
          return $identity->hashPassword($password);
        });
      $adapter = new AuthAdapter($options);

      $service = new AuthenticationService();
      $service->setAdapter($adapter);
      $service->setStorage($sm->get('AuthStorage'));
      
      return $service;
    },

    'AclService' => function($sm) {
      $config = include __DIR__ . '/acl.config.php';
      
      $acl = new Acl();

      foreach ($config['acl']['roles'] as $name => $parent) {
        $acl->addRole(new GenericRole($name), $parent ? explode(',', $parent) : null);
      };

      foreach ($config['acl']['resources'] as $permission => $controllers) {
        foreach ($controllers as $controller => $actions) {
          if ($controller == '*') {
            $controller = null;
          } else {
            if (!$acl->hasResource($controller)) {
              $acl->addResource(new GenericResource($controller));
            }
          };

          foreach ($actions as $action => $role) {
            if ($action == '*') {
              $action = null;
            };

            if ($permission == 'allow') {
              $acl->allow($role, $controller, $action);
            } elseif ($permission == 'deny') {
              $acl->deny($role, $controller, $action);
            }
          }
        }
      };

      return $acl;
    },

    'AuthStorage' => function($sm) {
      return new AuthStorage(
        array(
          'objectManager' => $sm->get('doctrine.entitymanager.orm_default'),
          'identityClass' => 'Main\Entity\User',
          'identityProperty' => 'email',
          'credentialProperty' => 'password',
          'credentialCallable' => function($identity, $password) {
            return $identity->hashPassword($password);
          }));
    },

    'AuthenticationEventHandler' => function($sm) { 
      return new \Main\Event\Authentication(); 
    }
  )
);