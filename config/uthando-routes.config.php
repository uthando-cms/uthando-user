<?php

use UthandoUser\Controller\AdminController;
use UthandoUser\Controller\AdminRegistrationController;
use UthandoUser\Controller\Settings;

return [
    'router' => [
        'routes' => [
            'admin' => [
                'child_routes' => [
                    'user' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/user',
                            'defaults' => [
                                '__NAMESPACE__' => 'UthandoUser\Controller',
                                'controller'    => AdminController::class,
                                'action'        => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'edit' => [
                                'type'    => 'Segment',
                                'options' => [
                                    'route'         => '/[:action[/id/[:id]]]',
                                    'constraints'   => [
                                        'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id'		=> '\d+'
                                    ],
                                    'defaults'      => [
                                        'controller'    => AdminController::class,
                                        'action'        => 'edit',
                                    ],
                                ],
                            ],
                            'page' => [
                                'type'    => 'Segment',
                                'options' => [
                                    'route'         => '/page/[:page]',
                                    'constraints'   => [
                                        'page'			=> '\d+'
                                    ],
                                    'defaults'      => [
                                        'controller'    => AdminController::class,
                                        'action'        => 'list',
                                        'page'          => 1,
                                    ],
                                ],
                            ],
                            'registration' => [
                                'type'    => 'Segment',
                                'options' => [
                                    'route'    => '/registration',
                                    'defaults' => [
                                        '__NAMESPACE__' => 'UthandoUser\Controller',
                                        'controller'    => AdminRegistrationController::class,
                                        'action'        => 'index',
                                    ],
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'edit' => [
                                        'type'    => 'Segment',
                                        'options' => [
                                            'route'         => '/[:action[/id/[:id]]]',
                                            'constraints'   => [
                                                'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id'		=> '\d+'
                                            ],
                                            'defaults'      => [
                                                'controller'    => AdminRegistrationController::class,
                                                'action'        => 'edit',
                                            ],
                                        ],
                                    ],
                                    'page' => [
                                        'type'    => 'Segment',
                                        'options' => [
                                            'route'         => '/page/[:page]',
                                            'constraints'   => [
                                                'page'			=> '\d+'
                                            ],
                                            'defaults'      => [
                                                'controller'    => AdminRegistrationController::class,
                                                'action'        => 'list',
                                                'page'          => 1,
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                            'settings' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '/settings[/:action]',
                                    'constraints' => [
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    ],
                                    'defaults' => [
                                        'controller'    => Settings::class,
                                        'action' => 'index',
                                    ]
                                ],
                                'may_terminate' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
