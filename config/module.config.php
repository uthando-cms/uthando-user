<?php

use UthandoUser\Authentication\Storage;
use UthandoUser\Controller\AdminController;
use UthandoUser\Controller\AdminRegistrationController;
use UthandoUser\Controller\LimitLoginController;
use UthandoUser\Controller\Plugin\IsAllowed as IsAllowedPlugin;
use UthandoUser\Controller\RegistrationController;
use UthandoUser\Controller\SettingsController as SettingsController;
use UthandoUser\Controller\UserController;
use UthandoUser\Options\LoginOptions;
use UthandoUser\Options\AuthOptions;
use UthandoUser\Options\UserOptions;
use UthandoUser\Service\Acl;
use UthandoUser\Service\Factory\AclFactory;
use UthandoUser\Service\Factory\AuthenticationFactory;
use UthandoUser\Service\Factory\AuthOptionsFactory;
use UthandoUser\Service\Factory\LoginOptionsFactory;
use UthandoUser\Service\Factory\UserNavigationFactory;
use UthandoUser\Service\Factory\UserOptionsFactory;
use UthandoUser\Service\LimitLoginService;
use UthandoUser\Service\UserService as UserService;
use UthandoUser\Service\UserRegistrationService as UserRegistrationService;
use UthandoUser\View\IsAllowed;
use Zend\Authentication\AuthenticationService;

return [
    'controllers' => [
        'invokables' => [
            AdminController::class              => AdminController::class,
            AdminRegistrationController::class  => AdminRegistrationController::class,
            LimitLoginController::class         => LimitLoginController::class,
            RegistrationController::class       => RegistrationController::class,
            SettingsController::class           => SettingsController::class,
            UserController::class               => UserController::class,
        ],
    ],
    'controller_plugins' => [
        'aliases' => [
            'isAllowed' => IsAllowedPlugin::class,
        ],
        'invokables' => [
            IsAllowedPlugin::class => IsAllowedPlugin::class,
        ],
    ],
    'service_manager' => [
        'aliases' => [
            'UthandoUser\Navigation'        => UserNavigationFactory::class,
            'UthandoUser\Options\User'      => UserOptions::class,
        ],
        'invokables' => [
            Storage::class => Storage::class,
        ],
        'factories' => [
            AuthenticationService::class    => AuthenticationFactory::class,
            Acl::class                      => AclFactory::class,
            UserNavigationFactory::class    => UserNavigationFactory::class,
            AuthOptions::class              => AuthOptionsFactory::class,
            LoginOptions::class             => LoginOptionsFactory::class,
            UserOptions::class              => UserOptionsFactory::class
        ],
    ],
    'uthando_services' => [
        'invokables' => [
            LimitLoginService::class        => LimitLoginService::class,
            UserService::class              => UserService::class,
            UserRegistrationService::class  => UserRegistrationService::class,
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'isAllowed' => IsAllowed::class,
        ],
        'invokables' => [
            IsAllowed::class => IsAllowed::class,
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
                        'controller'    => UserController::class,
                        'action'        => 'login',
                    ],
                ],
                'may_terminate' => true,
            ],
            'user' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/user[/[:action]]',
                    'constraints' => [
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*'
            		],
                    'defaults' => [
                        '__NAMESPACE__' => 'UthandoUser\Controller',
                        'controller'    => UserController::class,
                        'action'        => 'login',
                    ],
                ],
                'may_terminate' => true,
            ],
            'registration' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/registration[/[:action]/[:token]/[:email]]',
                    'constraints' => [
                        'action'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'token'     => '[a-zA-Z0-9]*',
                        //'email'     => '[a-zA-Z0-9@-_.]*',
                    ],
                    'defaults' => [
                        '__NAMESPACE__' => 'UthandoUser\Controller',
                        'controller'    => RegistrationController::class,
                        'token'         => '',
                        'email'         => '',
                    ],
                ],
                'may_terminate' => true,
            ],
        ],
    ],
];
