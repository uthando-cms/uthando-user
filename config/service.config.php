<?php

return [
    'invokables' => [
        'UthandoUser\Authentication\Storage'                => 'UthandoUser\Authentication\Storage',
        'UthandoUser\Service\User'                          => 'UthandoUser\Service\User'
    ],
    'factories' => [
        'Zend\Authentication\AuthenticationService'         => 'UthandoUser\Service\Factory\AuthenticationFactory',
        'UthandoUser\Service\Acl'                           => 'UthandoUser\Service\Factory\AclFactory',
        'UthandoUser\Navigation'                            => 'UthandoUser\Service\Factory\UserNavigationFactory'
    ],
];