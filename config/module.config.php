<?php
return [
	'user' => [
		'auth' => [
			'credentialTreatment'          => 'Zend\Crypt\Password\Bcrypt',
		    'useFallbackTreatment'         => false,
		    'fallbackCredentialTreatment'  => 'UthandoUser\Crypt\Password\Md5',
		],
	],
	'userAcl' => [
		'userRoles' => [
			'guest'			=> [
				'label'			=> 'Guest',
				'parent'		=> null,
				'privileges'	=> [
					'allow' => [
                        ['controller' => 'UthandoUser\Controller\User', 'action' => ['register', 'thank-you', 'login', 'authenticate']],
                    ],
				],
				'resources' => ['menu:guest'],
			],
			'registered'    => [
				'label'         => 'User',
				'parent'        => null,
				'privileges'    => [
					'allow' => [
                        ['controller' => 'UthandoUser\Controller\User', 'action' => ['edit', 'password', 'logout']],
                    ],
				],
				'resources' => ['menu:user'],
			],
			'admin'        => [
				'label'         => 'Admin',
				'parent'        => 'registered',
				'privileges'    => [
					'allow' => [
                        ['controller' => 'UthandoUser\Controller\Admin', 'action' => 'all'],
                    ],
				],
				'resources' => ['menu:admin'],
			],
		],
		'userResources' => [
			'UthandoUser\Controller\Admin',
			'UthandoUser\Controller\User',
		],
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
                        'action'        => 'index',
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
    'view_manager' => [
    	'template_map' => include __DIR__  .'/../template_map.php',
    ],
];
