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
            'credentialTreatment'         => 'Zend\Crypt\Password\Bcrypt',
            'useFallbackTreatment'        => false,
            'fallbackCredentialTreatment' => 'UthandoUser\Crypt\Password\Md5',
        ],
        'acl' => [
            'roles' => [
                'guest'			=> [
                    'label'			=> 'Guest',
                    'parent'		=> null,
                    'privileges'	=> [
                        'allow' => [
                            'controllers' => [
                                'UthandoUser\Controller\User' => ['action' => [
                                    'register', 'thank-you', 'login', 'authenticate', 'forgot-password'
                                ]],
                                'UthandoUser\Controller\Registration' => ['action' => [
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
                                'UthandoUser\Controller\User' => ['action' => [
                                    'register', 'thank-you', 'login', 'authenticate', 'forgot-password'
                                ]],
                                'UthandoUser\Controller\Registration' => ['action' => [
                                    'verify-email',
                                ]],
                            ],
                        ],
                        'allow' => [
                            'controllers' => [
                                'UthandoUser\Controller\User' => ['action' => ['edit', 'password', 'logout']]
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
                                'UthandoUser\Controller\Admin' => ['action' => 'all'],
                                'UthandoUser\Controller\Settings' => ['action' => 'all'],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                'UthandoUser\Controller\Admin',
                'UthandoUser\Controller\Registration',
                'UthandoUser\Controller\Settings',
                'UthandoUser\Controller\User',
            ],
        ],
    ],
];
