<?php

return [
    'uthando_user' => [
        'user_options' => [
            'loginMinPasswordLength' => 6,
            'loginMaxPasswordLength' => 16,
            'registerMinPasswordLength' => 8,
            'registerMaxPasswordLength' => 16
        ],
        'auth' => [
            'authenticateMethod'          => 'getUserByEmail',
            'credentialTreatment'         => Zend\Crypt\Password\Bcrypt::class,
            'useFallbackTreatment'        => false,
            'fallbackCredentialTreatment' => UthandoUser\Crypt\Password\Md5::class,
        ],
        'acl' => [
            'roles' => [
                'guest'			=> [
                    'label'			=> 'Guest',
                    'parent'		=> null,
                    'privileges'	=> [
                        'allow' => [
                            'controllers' => [
                                UthandoUser\Controller\User::class => ['action' => [
                                    'register', 'thank-you', 'login', 'authenticate', 'forgot-password'
                                ]],
                                UthandoUser\Controller\Registration::class => ['action' => [
                                    'verify-email',
                                ]],
                            ],
                        ],
                    ],
                ],
                'registered'    => [
                    'label'         => 'User',
                    'parent'        => 'guest',
                    'privileges'    => [
                        'deny' => [
                            'controllers' => [
                                UthandoUser\Controller\User::class => ['action' => [
                                    'register', 'thank-you', 'login', 'authenticate', 'forgot-password'
                                ]],
                                UthandoUser\Controller\Registration::class => ['action' => [
                                    'verify-email',
                                ]],
                            ],
                        ],
                        'allow' => [
                            'controllers' => [
                                UthandoUser\Controller\User::class => ['action' => ['edit', 'password', 'logout']]
                            ],
                        ],
                    ],
                ],
                'admin'        => [
                    'label'         => 'Admin',
                    'parent'        => 'registered',
                    'privileges'    => [
                        'allow' => [
                            'controllers' => [
                                UthandoUser\Controller\AdminController::class => ['action' => 'all'],
                                UthandoUser\Controller\Settings::class => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                UthandoUser\Controller\AdminController::class,
                UthandoUser\Controller\Registration::class,
                UthandoUser\Controller\Settings::class,
                UthandoUser\Controller\User::class,
            ],
        ],
    ],
];
