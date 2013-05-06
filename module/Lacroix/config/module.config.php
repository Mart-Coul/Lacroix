<?php

namespace Lacroix;

return array('controllers' => array('invokables' => array('Lacroix\Controller\Products' => 'Lacroix\Controller\ProductsController',
                                                          'Lacroix\Controller\NoteTemplates' => 'Lacroix\Controller\NoteTemplatesController',
                                                          'Lacroix\Controller\Rooms' => 'Lacroix\Controller\RoomsController',
                                                          'Lacroix\Controller\ProductionLines' => 'Lacroix\Controller\ProductionLinesController',
                                                          'Lacroix\Controller\DataEntries' => 'Lacroix\Controller\DataEntriesController',
                                                          'Lacroix\Controller\Users' => 'Lacroix\Controller\UsersController',
                                                          'Lacroix\Controller\Mobile' => 'Lacroix\Controller\MobileController',
                                                          'Lacroix\Controller\Configuration' => 'Lacroix\Controller\ConfigurationController',
                                                          
                                                          ),
                                    ),
             'router' => array('routes' => (include __DIR__ . '/routes.config.php')),
             'view_manager' => array(
                                     'template_path_stack' => array(
                                                                    'Lacroix' => __DIR__ . '/../view',
                                                                    ),
                                     'strategies' => array('ViewJsonStrategy')
                                     ),
             'doctrine' => array('driver' => array(__NAMESPACE__ . '_driver' => array('class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                                                                                      'cache' => 'array',
                                                                                      'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')),
                                                   'orm_default' => array('drivers' => array(__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver')))),
             );