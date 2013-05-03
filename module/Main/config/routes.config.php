<?php

return 
array(
  'home' => array(
    'type' => 'Literal',
    'options' => array(
      'route' => '/',
      'defaults' => array(
        '__NAMESPACE__' => 'Main\Controller',
        'controller' => 'Index',
        'action' => 'index',
      ),
    ),
  ),

  'users' => array(
    'type' => 'Segment',
    'options' => array(
      'route' => '/users',
      'defaults' => array(
        '__NAMESPACE__' => 'Main\Controller',
        'controller' => 'Users',
      ),
    ),

    'child_routes' => array(
      'login' => array(
        'type' => 'Segment',
        'options' => array(
          'route' => '/login',
          'defaults' => array(
            'action' => 'login'
          ),
        ),
      ),

      'authenticate' => array(
        'type' => 'Segment',
        'options' => array(
          'route' => '/authenticate',
          'defaults' => array(
            'action' => 'authenticate'
          ),
        ),
      ),

      'logout' => array(
        'type' => 'Segment',
        'options' => array(
          'route' => '/logout',
          'defaults' => array(
            'action' => 'logout'
          ),
        ),
      )
    ),
  ),
);
