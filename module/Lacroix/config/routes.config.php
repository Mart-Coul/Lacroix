<?php

$rest_routes = array(
  'new' => array(
    'type' => 'Segment',
    'options' => array(
      'route' => '/new',
      'defaults' => array(
        'action' => 'new'
      ),
    ),
  ),

  'create' => array(
    'type' => 'Segment',
    'options' => array(
      'route' => '/create',
      'defaults' => array(
        'action' => 'create'
      ),
    ),
  ),

  'edit' => array(
    'type' => 'Segment',
    'options' => array(
      'route' => '/edit/:id',
      'defaults' => array(
        'action' => 'edit'
      ),
    ),
  ),

  'update' => array(
    'type' => 'Segment',
    'options' => array(
      'route' => '/update/:id',
      'defaults' => array(
        'action' => 'update'
      ),
    ),
  ),

  'delete' => array(
    'type' => 'Segment',
    'options' => array(
      'route' => '/delete/:id',
      'defaults' => array(
        'action' => 'delete'
      ),
    ),
  ),

  'confirm-delete' => array(
    'type' => 'Segment',
    'options' => array(
      'route' => '/delete/:id/confirm',
      'defaults' => array(
        'action' => 'confirm-delete'
      ),
    ),
  ),
);

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
    'child_routes' => $rest_routes,
  ),

  'note-templates' => array(
    'type' => 'Segment',
    'options' => array(
      'route' => '/note-templates',
      'defaults' => array(
        '__NAMESPACE__' => 'Lacroix\Controller',
        'controller' => 'NoteTemplates',
        'action' => 'index'
      ),
    ),

    'may_terminate' => true,
    'child_routes' => $rest_routes,
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
    'child_routes' => $rest_routes,
  ),

  'production-lines' => array(
    'type' => 'Segment',
    'options' => array(
      'route' => '/production-lines',
      'defaults' => array(
        '__NAMESPACE__' => 'Lacroix\Controller',
        'controller' => 'ProductionLines',
        'action' => 'index'
      ),
    ),

    'may_terminate' => true,
    'child_routes' => $rest_routes,
  ),

  'admin-users' => array(
    'type' => 'Segment',
    'options' => array(
      'route' => '/admin/users',
      'defaults' => array(
        '__NAMESPACE__' => 'Lacroix\Controller',
        'controller' => 'Users',
        'action' => 'index'
      ),
    ),

    'may_terminate' => true,
    'child_routes' => $rest_routes,
  ),

  'configuration' => array(
    'type' => 'Segment',
    'options' => array(
      'route' => '/configuration',
      'defaults' => array(
        '__NAMESPACE__' => 'Lacroix\Controller',
        'controller' => 'Configuration',
        'action' => 'index'
      ),
    ),

    'may_terminate' => true,
    'child_routes' => array(
    ),
  ),

  'mobile' => array(
    'type' => 'Segment',
    'options' => array(
      'route' => '/mobile',
      'defaults' => array(
        '__NAMESPACE__' => 'Lacroix\Controller',
        'controller' => 'Mobile',
        'action' => 'index'
      ),
    ),

    'may_terminate' => true,
    'child_routes' => array(
      'line' => array(
        'type' => 'Segment',
        'options' => array(
          'route' => '/line/:line_id',
          'defaults' => array(
          ),
        ),

        'may_terminate' => false,
        'child_routes' => array(
          'line' => array(
            'type' => 'Segment',
            'options' => array(
              'route' => '/readings',
              'defaults' => array(
                'action' => 'add-reading'
              ),
            ),

            'may_terminate' => true,
            'child_routes' => array(
            ),
          ),
        ),
      ),

      'room' => array(
        'type' => 'Segment',
        'options' => array(
          'route' => '/room/:room_id',
          'defaults' => array(
            'action' => 'room'
          ),
        ),

        'may_terminate' => true,
        'child_routes' => array(
        ),
      ),
    ),
  ),
);
