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
                                'controller'    => 'Admin',
                                'action'        => 'index',
                                'force-ssl'     => 'ssl'
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
                                        'action'        => 'edit',
                                        'force-ssl'     => 'ssl'
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
                                        'action'        => 'list',
                                        'page'          => 1,
                                        'force-ssl'     => 'ssl'
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
                                        'controller' => 'Settings',
                                        'action' => 'index',
                                        'force-ssl' => 'ssl'
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
