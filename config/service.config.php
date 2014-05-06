<?php
return [
    'shared' => [
        'UthandoUser\Form\Password'                         => false,
        'UthandoUser\Form\User'                             => false
    ],
    'invokables' => [
        'UthandoUser\Form\Password'                         => 'UthandoUser\Form\Password',
        'UthandoUser\Form\User'                             => 'UthandoUser\Form\User',
        
        'UthandoUser\InputFilter\Password'                  => 'UthandoUser\InputFilter\Password',
        'UthandoUser\InputFilter\User'                      => 'UthandoUser\InputFilter\User',
        
        'UthandoUser\Mapper\User'                           => 'UthandoUser\Mapper\User',
        
        'UthandoUser\Service\User'                          => 'UthandoUser\Service\User'
    ],
    'factories' => [
        'Zend\Authentication\AuthenticationService'         => 'UthandoUser\Service\Factory\AuthenticationFactory',
        'UthandoUser\Service\Acl'                           => 'UthandoUser\Service\Factory\AclFactory',
        'UthandoUser\Navigation'                            => 'UthandoUser\Service\Factory\UserNavigationFactory'
    ],
    'initializers' => [ 
        'UthandoUser\Service\Initializer\AclInitializer'    => 'UthandoUser\Service\Initializer\AclInitializer',
    ],
];