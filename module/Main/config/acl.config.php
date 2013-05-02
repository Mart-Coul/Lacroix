<?php

return array('acl' => array('roles' => array('guest' => null,
                                             'user' => 'guest',
                                             'admin' => 'user',
                                             'production' => 'user'),
                            'resources' => array('allow' => array('*' => array('*' => 'admin'),
                                                                  'Main\Controller\Users' => array('login' => 'guest',
                                                                                                   'authenticate' => 'guest',
                                                                                                   'logout' => 'user'),
                                                                  ))
                            ));