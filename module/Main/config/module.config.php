<?php

namespace Main;

return array('controllers' => array('invokables' => array('Main\Controller\Index' => 'Main\Controller\IndexController',
                                                          'Main\Controller\Users' => 'Main\Controller\UsersController'
                                                          
                                                          ),
                                    ),
             'router' => array('routes' => (include __DIR__ . '/routes.config.php')),
             'view_manager' => array(
                                     'template_path_stack' => array(
                                                                    'Main' => __DIR__ . '/../view',
                                                                    ),
                                     'strategies' => array('ViewJsonStrategy')
                                     ),
             'doctrine' => array('driver' => array(__NAMESPACE__ . '_driver' => array('class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                                                                                      'cache' => 'array',
                                                                                      'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')),
                                                   'orm_default' => array('drivers' => array(__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver')))),
             'translator' => array('translation_file_patterns' => array(array('type' => 'gettext',
                                                                              'base_dir' => __DIR__ . '/../../../public/i18n',
                                                                              'pattern' => '%s.mo')),
                                   'text_domain' => 'messages')
             );