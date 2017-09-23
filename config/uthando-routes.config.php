<?php

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
                                'controller'    => UthandoUser\Controller\AdminController::class,
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
                                        'controller'    => UthandoUser\Controller\AdminController::class,
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
                                        'controller'    => UthandoUser\Controller\AdminController::class,
                                        'action'        => 'list',
                                        'page'          => 1,
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
                                        'controller'    => UthandoUser\Controller\Settings::class,
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
