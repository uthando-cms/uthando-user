<?php
return [
    'controllers' => [
        'invokables' => [
            'UthandoUser\Controller\Admin'          => 'UthandoUser\Controller\AdminController',
            'UthandoUser\Controller\Registration'   => 'UthandoUser\Controller\RegistrationController',
            'UthandoUser\Controller\Settings'       => 'UthandoUser\Controller\Settings',
            'UthandoUser\Controller\User'           => 'UthandoUser\Controller\UserController',
        ],
    ],
    'controller_plugins' => [
        'invokables' => [
            'IsAllowed' => 'UthandoUser\Controller\Plugin\IsAllowed'
        ],
    ],
    'form_elements' => [
        'invokables' => [
            'UthandoUserEdit'           => 'UthandoUser\Form\UserEdit',
            'UthandoUserForgotPassword' => 'UthandoUser\Form\ForgotPassword',
            'UthandoUserLogin'          => 'UthandoUser\Form\Login',
            'UthandoUserRegister'       => 'UthandoUser\Form\Register',
            'UthandoUser'               => 'UthandoUser\Form\User',
            'UthandoUserSearch'         => 'UthandoUser\Form\UserSearch',

            'UthandoUserRoleList'       => 'UthandoUser\Form\Element\RoleList',
            'UthandoUserList'           => 'UthandoUser\Form\Element\UserList',

            'UthandoUserAuthFieldSet'   => 'UthandoUser\Form\Settings\AuthFieldSet',
            'UthandoUserSettings'       => 'UthandoUser\Form\Settings\Settings',
            'UthandoUserFieldSet'       => 'UthandoUser\Form\Settings\UserFieldSet',
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
            'UthandoUser\Navigation'                    => 'UthandoUser\Service\Factory\UserNavigationFactory',
            'UthandoUser\Options\Auth'                  => 'UthandoUser\Service\Factory\AuthOptionsFactory',
            'UthandoUser\Options\User'                  => 'UthandoUser\Service\Factory\UserOptionsFactory',
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
            'login' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/login',
                    'defaults' => [
                        '__NAMESPACE__' => 'UthandoUser\Controller',
                        'controller'    => 'User',
                        'action'        => 'login',
                        'force-ssl'     => 'ssl'
                    ],
                ],
                'may_terminate' => true,
            ],
            'user' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/user/[:action]',
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
        ],
    ],
];
