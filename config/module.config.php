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
                        ['controller' => 'UthandoUser\Controller\Auth', 'action' => ['login', 'authenticate']],
                        ['controller' => 'UthandoUser\Controller\User', 'action' => ['register', 'thank-you']],
                    ],
				],
				'resources' => ['menu:guest'],
			],
			'registered'    => [
				'label'         => 'User',
				'parent'        => null,
				'privileges'    => [
					'allow' => [
                        ['controller' => 'UthandoUser\Controller\Auth', 'action' => ['logout']],
                        ['controller' => 'UthandoUser\Controller\User', 'action' => ['edit', 'password']],
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
			'UthandoUser\Controller\Auth',
			'UthandoUser\Controller\User',
		],
	],
    'router' => [
        'routes' => [
            'user' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/user',
                    'defaults' => [
                        '__NAMESPACE__' => 'UthandoUser\Controller',
                        'controller'    => 'User',
                        'action'        => 'index',
                        'force-ssl'     => 'ssl'
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                	'default' => [
                		'type' => 'Segment',
                		'options' => [
                			'route' => '/[:action]',
                			'constraints' => [
                				'action'     => '[a-zA-Z][a-zA-Z0-9_-]*'
                			],
                			'defaults' => [
                				'controller'    => 'User',
                				'action'        => 'index',
                			    'force-ssl'     => 'ssl'
                			],
                		],
                	],
                	'register' => [
                		'type' => 'Literal',
                		'options' => [
                			'route' => '/register',
                			'defaults' => [
                				'controller'    => 'User',
                				'action'        => 'register',
                			    'force-ssl'     => 'ssl'
                			],
                		],
                	],
                	'thank-you' => [
                		'type' => 'Literal',
                		'options' => [
                			'route' => '/thank-you',
                			'defaults' => [
                				'controller'    => 'User',
                				'action'        => 'thank-you',
                			    'force-ssl'     => 'ssl'
                			],
                		],
                	],
                    'authenticate' => [
						'type' => 'Literal',
						'options' => [
							'route' => '/authenticate',
							'defaults' => [
								'controller'    => 'Auth',
								'action'        => 'authenticate',
							    'force-ssl'     => 'ssl'
							],
						],
    				],
    				'logout' => [
    					'type' => 'Literal',
    					'options' => [
    						'route' => '/logout',
    						'defaults' => [
    							'controller'    => 'Auth',
    							'action'        => 'logout',
    						    'force-ssl'     => 'ssl'
    						],
    					],
    				],
    				'login' => [
						'type' => 'Literal',
						'options' => [
							'route' => '/login',
							'defaults' => [
								'controller'    => 'Auth',
								'action'        => 'login',
							    'force-ssl'     => 'ssl'
							],
						],
    				],
                ],
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
                'route'     => 'user/login',
                'resource'  => 'menu:guest',
            ],
            'logout' => [
                'label'     => 'Sign Out',
                'action'    => 'logout',
                'route'     => 'user/logout',
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
                'route'     => 'user/default',
                'resource'  => 'menu:user',
            ],
            'password' => [
            	'label'     => 'Password',
                'action'    => 'password',
                'route'     => 'user/default',
                'resource'  => 'menu:user',
            ],
	        'logout' => [
	            'label'    => 'Logout',
	            'action'   => 'logout',
	            'route'    => 'user/logout',
	            'resource' => 'menu:user',
	        ],
        ],
	],
    'view_manager' => [
    	'template_map' => include __DIR__  .'/../template_map.php',
    ],
];
