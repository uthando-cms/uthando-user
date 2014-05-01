<?php

return [
    'UthandoUser\Module'                                => __DIR__ . '/Module.php',
    
    'UthandoUser\Authentication\Adapter'                => __DIR__ . '/src/UthandoUser/Authentication/Adapter.php',
    
    'UthandoUser\Controller\AdminController'            => __DIR__ . '/src/UthandoUser/Controller/AdminController.php',
    'UthandoUser\Controller\AuthController'             => __DIR__ . '/src/UthandoUser/Controller/AuthController.php',
    'UthandoUser\Controller\Plugin\IsAllowed'           => __DIR__ . '/src/UthandoUser/Controller/Plugin/IsAllowed.php',
    'UthandoUser\Controller\UserController'             => __DIR__ . '/src/UthandoUser/Controller/UserController.php',
    
    'UthandoUser\Crypt\Password\Md5'                    => __DIR__ . '/src/UthandoUser/Crypt/Password/Md5.php',
    
    'UthandoUser\Event\MvcListener'                     => __DIR__ . '/src/UthandoUser/Event/MvcListener.php',
    
    'UthandoUser\Form\Login'                            => __DIR__ . '/src/UthandoUser/Form/Login.php',
    'UthandoUser\Form\Password'                         => __DIR__ . '/src/UthandoUser/Form/Password.php',
    'UthandoUser\Form\User'                             => __DIR__ . '/src/UthandoUser/Form/User.php',
    'UthandoUser\Form\UserSearch'                       => __DIR__ . '/src/UthandoUser/Form/UserSearch.php',
    
    'UthandoUser\Hydrator\User'                         => __DIR__ . '/src/UthandoUser/Hydrator/User.php',
    
    'UthandoUser\InputFilter\Login'                     => __DIR__ . '/src/UthandoUser/InputFilter/Login.php',
    'UthandoUser\InputFilter\User'                      => __DIR__ . '/src/UthandoUser/InputFilter/User.php',
    'UthandoUser\InputFilter\Password'                  => __DIR__ . '/src/UthandoUser/InputFilter/Password.php',
    
    'UthandoUser\Mapper\User'                           => __DIR__ . '/src/UthandoUser/Mapper/User.php',
    
    'UthandoUser\Model\User'                            => __DIR__ . '/src/UthandoUser/Model/User.php',
    
    'UthandoUser\Service\Acl'                           => __DIR__ . '/src/UthandoUser/Service/Acl.php',
    'UthandoUser\Service\Authentication'                => __DIR__ . '/src/UthandoUser/Service/Authentication.php',
    'UthandoUser\Service\Factory\AclFactory'            => __DIR__ . '/src/UthandoUser/Service/Factory/AclFactory.php',
    'UthandoUser\Service\Factory\AuthControllerFactory' => __DIR__ . '/src/UthandoUser/Service/Factory/AuthControllerFactory.php',
    'UthandoUser\Service\Factory\AuthenticationFactory' => __DIR__ . '/src/UthandoUser/Service/Factory/AuthenticationFactory.php',
    'UthandoUser\Service\Factory\UserNavigationFactory' => __DIR__ . '/src/UthandoUser/Service/Factory/UserNavigationFactory.php',
    'UthandoUser\Service\User'                          => __DIR__ . '/src/UthandoUser/Service/User.php',
    
    'UthandoUser\UthandoUserException'                  => __DIR__ . '/src/UthandoUser/UthandoUserException.php',
    
    'UthandoUser\View\IsAllowed'                        => __DIR__ . '/src/UthandoUser/View/IsAllowed.php'
];
