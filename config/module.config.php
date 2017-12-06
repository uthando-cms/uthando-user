<?php

use UthandoUser\Authentication\Storage;
use UthandoUser\Controller\AdminController;
use UthandoUser\Controller\AdminRegistrationController;
use UthandoUser\Controller\LimitLoginController;
use UthandoUser\Controller\Plugin\IsAllowed as IsAllowedPlugin;
use UthandoUser\Controller\RegistrationController;
use UthandoUser\Controller\Settings as SettingsController;
use UthandoUser\Controller\UserController;
use UthandoUser\Form\Element\RoleList;
use UthandoUser\Form\Element\UserList;
use UthandoUser\Form\ForgotPassword;
use UthandoUser\Form\Login;
use UthandoUser\Form\Password;
use UthandoUser\Form\Register;
use UthandoUser\Form\Settings\AuthFieldSet;
use UthandoUser\Form\Settings\Settings;
use UthandoUser\Form\Settings\LoginFieldSet;
use UthandoUser\Form\Settings\UserFieldSet;
use UthandoUser\Form\User;
use UthandoUser\Form\UserEdit;
use UthandoUser\Hydrator\LimitLoginHydrator;
use UthandoUser\Hydrator\User as UserHydrator;
use UthandoUser\Hydrator\UserRegistration;
use UthandoUser\InputFilter\User as UserInputFilter;
use UthandoUser\Mapper\LimitLoginMapper;
use UthandoUser\Mapper\User as UserMapper;
use UthandoUser\Mapper\UserRegistration as UserRegistrationMapper;
use UthandoUser\Model\LimitLoginModel;
use UthandoUser\Model\User as UserModel;
use UthandoUser\Model\UserRegistration as UserRegistrationModel;
use UthandoUser\Option\LoginOptions;
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
use UthandoUser\Service\User as UserService;
use UthandoUser\Service\UserRegistration as UserRegistrationService;
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
    'form_elements' => [
        'aliases' => [
            'UthandoUserEdit'           => UserEdit::class,
            'UthandoUserForgotPassword' => ForgotPassword::class,
            'UthandoUserPassword'       => Password::class,
            'UthandoUserLogin'          => Login::class,
            'UthandoUserRegister'       => Register::class,
            'UthandoUser'               => User::class,

            'UthandoUserRoleList'       => RoleList::class,
            'UthandoUserList'           => UserList::class,

            'UthandoUserAuthFieldSet'   => AuthFieldSet::class,
            'UthandoUserSettings'       => Settings::class,
            'UthandoUserLoginFieldSet'  => LoginFieldSet::class,
        ],
        'invokables' => [
            UserEdit::class         => UserEdit::class,
            ForgotPassword::class   => ForgotPassword::class,
            Password::class         => Password::class,
            Login::class            => Login::class,
            Register::class         => Register::class,
            User::class             => User::class,

            RoleList::class         => RoleList::class,
            UserList::class         => UserList::class,

            AuthFieldSet::class     => AuthFieldSet::class,
            Settings::class         => Settings::class,
            LoginFieldSet::class    => LoginFieldSet::class,
            UserFieldSet::class     => UserFieldSet::class
        ],
    ],
    'hydrators' => [
        'aliases' => [
            'UthandoUser'               => UserHydrator::class,
            'UthandoUserRegistration'   => UserRegistration::class,
        ],
        'invokables' => [
            LimitLoginHydrator::class => LimitLoginHydrator::class,
            UserHydrator::class       => UserHydrator::class,
            UserRegistration::class   => UserRegistration::class,
        ],
    ],
    'input_filters' => [
        'aliases' => [
            'UthandoUser' => UserInputFilter::class,
        ],
        'invokables' => [
            UserInputFilter::class => UserInputFilter::class,
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
    'uthando_mappers' => [
        'aliases' => [
            'UthandoUser'               => UserMapper::class,
            'UthandoUserRegistration'   => UserRegistrationMapper::class,
        ],
        'invokables' => [
            LimitLoginMapper::class         => LimitLoginMapper::class,
            UserMapper::class               => UserMapper::class,
            UserRegistrationMapper::class   => UserRegistrationMapper::class,
        ],
    ],
    'uthando_models' => [
        'aliases' => [
            'UthandoUser'               => UserModel::class,
            'UthandoUserRegistration'   => UserRegistrationModel::class,
        ],
        'invokables' => [
            LimitLoginModel::class          => LimitLoginModel::class,
            UserModel::class                => UserModel::class,
            UserRegistrationModel::class    => UserRegistrationModel::class,
        ],
    ],
    'uthando_services' => [
        'aliases' => [
            'UthandoUser'               => UserService::class,
            'UthandoUserRegistration'   => UserRegistrationService::class,
        ],
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
