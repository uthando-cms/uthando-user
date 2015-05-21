<?php
return [
	'uthando_user' => [
		'auth' => [
		    'AuthenticateMethod'          => 'getUserByEmail',
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
                                'UthandoUser\Controller\Admin' => ['action' => 'all']],
                        ],
                    ],
                ],
            ],
            'resources' => [
                'UthandoUser\Controller\Admin',
                'UthandoUser\Controller\Registration',
                'UthandoUser\Controller\User',
            ],
        ],
	],
    'controllers' => [
        'invokables' => [
            'UthandoUser\Controller\Admin'          => 'UthandoUser\Controller\AdminController',
            'UthandoUser\Controller\Registration'   => 'UthandoUser\Controller\RegistrationController',
            'UthandoUser\Controller\User'           => 'UthandoUser\Controller\UserController'
        ],
    ],
    'controller_plugins' => [
        'invokables' => [
            'IsAllowed' => 'UthandoUser\Controller\Plugin\IsAllowed'
        ],
    ],
    'form_elements' => [
        'invokables' => [
            'UthandoUserLogin'      => 'UthandoUser\Form\Login',
            'UthandoUserRegister'   => 'UthandoUser\Form\Register',
            'UthandoUser'           => 'UthandoUser\Form\User',
            'UthandoUserSearch'     => 'UthandoUser\Form\UserSearch',

            'UthandoUserRoleList'   => 'UthandoUser\Form\Element\RoleList',
            'UthandoUserList'       => 'UthandoUser\Form\Element\UserList',
        ],
    ],
    'hydrators' => [
        'invokables' => [
            'UthandoUser'               => 'UthandoUser\Hydrator\User',
            'UthandoUserRegistration'   => 'UthandoUser\Hydrator\UserRegistration',
        ],
    ],
    'input_filters' => [
        'invokables' => [
            'UthandoUser' => 'UthandoUser\InputFilter\User',
        ],
    ],
    'service_manager' => [
        'invokables' => [
            'UthandoUser\Authentication\Storage' => 'UthandoUser\Authentication\Storage',
        ],
        'factories' => [
            'Zend\Authentication\AuthenticationService' => 'UthandoUser\Service\Factory\AuthenticationFactory',
            'UthandoUser\Service\Acl'                   => 'UthandoUser\Service\Factory\AclFactory',
            'UthandoUser\Navigation'                    => 'UthandoUser\Service\Factory\UserNavigationFactory'
        ],
    ],
    'uthando_mappers' => [
        'invokables' => [
            'UthandoUser'               => 'UthandoUser\Mapper\User',
            'UthandoUserRegistration'   => 'UthandoUser\Mapper\UserRegistration',
        ],
    ],
    'uthando_models' => [
        'invokables' => [
            'UthandoUser'               => 'UthandoUser\Model\User',
            'UthandoUserRegistration'   => 'UthandoUser\Model\UserRegistration',
        ],
    ],
    'uthando_services' => [
        'invokables' => [
            'UthandoUser'               => 'UthandoUser\Service\User',
            'UthandoUserRegistration'   => 'UthandoUser\Service\UserRegistration',
        ],
    ],
    'view_helpers' => [
        'invokables' => [
            'IsAllowed' => 'UthandoUser\View\IsAllowed',
        ],
    ],
    'view_manager' => [
        'template_map' => include __DIR__  .'/../template_map.php',
    ],
    'router' => [
        'routes' => [
            'user' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/user[/[:action]]',
                    'constraints' => [
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*'
            		],
                    'defaults' => [
                        '__NAMESPACE__' => 'UthandoUser\Controller',
                        'controller'    => 'User',
                        'action'        => 'login',
                        'force-ssl'     => 'ssl'
                    ],
                ],
                'may_terminate' => true,
            ],
            'registration' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/registration[/[:action]/[:token]/[:email]]',
                    'constraints' => [
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'token'     => '[a-zA-Z0-9]*',
                    ],
                    'defaults' => [
                        '__NAMESPACE__' => 'UthandoUser\Controller',
                        'controller'    => 'Registration',
                        'token'         => '',
                        'email'         => '',
                        'force-ssl'     => 'ssl'
                    ],
                ],
                'may_terminate' => true,
            ],
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
        				],
        			],
        		],
        	],
        ],
    ],
	'navigation' => [
        'default' => [
            'login' => [
                'label'     => 'Sing In',
                'action'    => 'login',
                'route'     => 'user',
                'resource'  => 'menu:guest',
            ],
            'logout' => [
                'label'     => 'Sign Out',
                'action'    => 'logout',
                'route'     => 'user',
                'resource'  => 'menu:user',
            ],
        ],
		'admin' => [
			'modules' => [
                'pages' => [
                    'user' => [
                        'label' => 'User',
                        'pages' => [
                            'list' => [
                                'label'     => 'List All Users',
                                'action'    => 'index',
                                'route'     => 'admin/user',
                                'resource'  => 'menu:admin'
                            ],
                            'add' => [
                                'label'     => 'Add New User',
                                'action'    => 'add',
                                'route'     => 'admin/user/edit',
                                'resource'  => 'menu:admin'
                            ],
                        ],
                        'route'     => 'admin/user',
                        'resource'  => 'menu:admin'
                    ],
                ],
            ],
		],
	    'user' => [
            'edit_profile' => [
                'label'     => 'Edit Profile',
                'action'    => 'edit',
                'route'     => 'user',
                'resource'  => 'menu:user',
            ],
            'password' => [
            	'label'     => 'Password',
                'action'    => 'password',
                'route'     => 'user',
                'resource'  => 'menu:user',
            ],
	        'logout' => [
	            'label'    => 'Logout',
	            'action'   => 'logout',
	            'route'    => 'user',
	            'resource' => 'menu:user',
	        ],
        ],
	],
];
