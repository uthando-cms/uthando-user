<?php

return [
    'uthando_user' => [
        'acl' => [
            'roles' => [
                'guest' => [
                    'label' => 'Guest',
                    'parent' => null,
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                \UthandoUser\Controller\User::class => ['action' => [
                                    'register', 'thank-you', 'login', 'authenticate', 'forgot-password'
                                ]],
                                \UthandoUser\Controller\Registration::class => ['action' => [
                                    'verify-email',
                                ]],
                            ],
                        ],
                    ],
                ],
                'registered' => [
                    'label' => 'User',
                    'parent' => 'guest',
                    'privileges' => [
                        'deny' => [
                            'controllers' => [
                                \UthandoUser\Controller\User::class => ['action' => [
                                    'register', 'thank-you', 'login', 'authenticate', 'forgot-password'
                                ]],
                                \UthandoUser\Controller\Registration::class => ['action' => [
                                    'verify-email',
                                ]],
                            ],
                        ],
                        'allow' => [
                            'controllers' => [
                                \UthandoUser\Controller\User::class => ['action' => ['edit', 'password', 'logout']]
                            ],
                        ],
                    ],
                ],
                'admin' => [
                    'label' => 'Admin',
                    'parent' => 'registered',
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                UthandoUser\Controller\AdminController::class => ['action' => 'all'],
                                \UthandoUser\Controller\AdminRegistrationController::class => [
                                    'action' => ['index', 'list', 'delete']
                                ],
                                \UthandoUser\Controller\Settings::class => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                \UthandoUser\Controller\AdminController::class,
                \UthandoUser\Controller\AdminRegistrationController::class,
                \UthandoUser\Controller\Registration::class,
                \UthandoUser\Controller\Settings::class,
                \UthandoUser\Controller\User::class,
            ],
        ],
    ],
];
