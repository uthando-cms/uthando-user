<?php

use UthandoUser\Controller;
use UthandoUser\Form;
use UthandoUser\Hydrator;
use UthandoUser\InputFilter;
use UthandoUser\Service;

return [
    'controllers' => [
        'invokables' => [
            Controller\AdminController::class           => Controller\AdminController::class,
            Controller\RegistrationController::class    => Controller\RegistrationController::class,
            'UthandoUser\Controller\Registration'       => Controller\RegistrationController::class,
            'UthandoUser\Controller\Settings'           => Controller\Settings::class,
            'UthandoUser\Controller\User'               => Controller\UserController::class,
        ],
    ],
    'controller_plugins' => [
        'invokables' => [
            'IsAllowed' => Controller\Plugin\IsAllowed::class,
        ],
    ],
    'form_elements' => [
        'invokables' => [
            'UthandoUserEdit'           => Form\UserEdit::class,
            'UthandoUserForgotPassword' => Form\ForgotPassword::class,
            'UthandoUserPassword'       => Form\Password::class,
            'UthandoUserLogin'          => Form\Login::class,
            'UthandoUserRegister'       => Form\Register::class,
            'UthandoUser'               => Form\User::class,

            'UthandoUserRoleList'       => Form\Element\RoleList::class,
            'UthandoUserList'           => Form\Element\UserList::class,

            'UthandoUserAuthFieldSet'   => Form\Settings\AuthFieldSet::class,
            'UthandoUserSettings'       => Form\Settings\Settings::class,
            'UthandoUserFieldSet'       => Form\Settings\UserFieldSet::class,
        ],
    ],
    'hydrators' => [
        'invokables' => [
            'UthandoUser'               => Hydrator\User::class,
            'UthandoUserRegistration'   => Hydrator\UserRegistration::class,
        ],
    ],
    'input_filters' => [
        'invokables' => [
            'UthandoUser' => InputFilter\User::class,
        ],
    ],
    'service_manager' => [
        'invokables' => [
            'UthandoUser\Authentication\Storage' => UthandoUser\Authentication\Storage::class,
        ],
        'factories' => [
            Zend\Authentication\AuthenticationService::class    => Service\Factory\AuthenticationFactory::class,
            UthandoUser\Service\Acl::class                      => Service\Factory\AclFactory::class,
            'UthandoUser\Navigation'                            => Service\Factory\UserNavigationFactory::class,
            'UthandoUser\Options\Auth'                          => Service\Factory\AuthOptionsFactory::class,
            'UthandoUser\Options\User'                          => Service\Factory\UserOptionsFactory::class,
        ],
    ],
    'uthando_mappers' => [
        'invokables' => [
            'UthandoUser'               => UthandoUser\Mapper\User::class,
            'UthandoUserRegistration'   => UthandoUser\Mapper\UserRegistration::class,
        ],
    ],
    'uthando_models' => [
        'invokables' => [
            'UthandoUser'               => UthandoUser\Model\User::class,
            'UthandoUserRegistration'   => UthandoUser\Model\UserRegistration::class,
        ],
    ],
    'uthando_services' => [
        'invokables' => [
            'UthandoUser'               => UthandoUser\Service\User::class,
            'UthandoUserRegistration'   => UthandoUser\Service\UserRegistration::class,
        ],
    ],
    'view_helpers' => [
        'invokables' => [
            'IsAllowed' => UthandoUser\View\IsAllowed::class,
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
