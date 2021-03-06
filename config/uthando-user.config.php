<?php

use UthandoUser\Controller\AdminController;
use UthandoUser\Controller\AdminRegistrationController;
use UthandoUser\Controller\LimitLoginController;
use UthandoUser\Controller\RegistrationController;
use UthandoUser\Controller\SettingsController;
use UthandoUser\Controller\UserController;

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
                                UserController::class => ['action' => [
                                    'register', 'thank-you', 'login', 'authenticate', 'forgot-password'
                                ]],
                                RegistrationController::class => ['action' => [
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
                                UserController::class => ['action' => [
                                    'register', 'thank-you', 'login', 'authenticate', 'forgot-password'
                                ]],
                                RegistrationController::class => ['action' => [
                                    'verify-email',
                                ]],
                            ],
                        ],
                        'allow' => [
                            'controllers' => [
                                UserController::class => [
                                    'action' => ['edit', 'password', 'logout']
                                ]
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
                                AdminController::class => ['action' => 'all'],
                                AdminRegistrationController::class => [
                                    'action' => ['index', 'list', 'delete']
                                ],
                                LimitLoginController::class => [
                                    'action' => ['index', 'list', 'delete']
                                ],
                                SettingsController::class => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                AdminController::class,
                AdminRegistrationController::class,
                LimitLoginController::class,
                RegistrationController::class,
                SettingsController::class,
                UserController::class,
            ],
        ],
    ],
];
