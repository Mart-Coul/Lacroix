<?php

return 
array(
  'rooms' => array(
    'type' => 'Segment',
    'options' => array(
      'route' => '/rooms',
      'defaults' => array(
        '__NAMESPACE__' => 'Lacroix\Controller',
        'controller' => 'Rooms',
        'action' => 'index'
      ),
    ),

    'may_terminate' => true,
    'child_routes' => array(
    ),
  ),

  'note_templates' => array(
    'type' => 'Segment',
    'options' => array(
      'route' => '/note_templates',
      'defaults' => array(
        '__NAMESPACE__' => 'Lacroix\Controller',
        'controller' => 'NoteTemplates',
        'action' => 'index'
      ),
    ),

    'may_terminate' => true,
    'child_routes' => array(
    ),
  ),

  'products' => array(
    'type' => 'Segment',
    'options' => array(
      'route' => '/products',
      'defaults' => array(
        '__NAMESPACE__' => 'Lacroix\Controller',
        'controller' => 'Products',
        'action' => 'index'
      ),
    ),

    'may_terminate' => true,
    'child_routes' => array(
    ),
  ),

  'production_lines' => array(
    'type' => 'Segment',
    'options' => array(
      'route' => '/production_lines',
      'defaults' => array(
        '__NAMESPACE__' => 'Lacroix\Controller',
        'controller' => 'ProductionLines',
        'action' => 'index'
      ),
    ),

    'may_terminate' => true,
    'child_routes' => array(
    ),
  ),
);
