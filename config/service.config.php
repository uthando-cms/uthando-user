<?php

return [
    'invokables' => [
        'UthandoUser\Authentication\Storage'                => 'UthandoUser\Authentication\Storage',
    ],
    'factories' => [
        'Zend\Authentication\AuthenticationService'         => 'UthandoUser\Service\Factory\AuthenticationFactory',
        'UthandoUser\Service\Acl'                           => 'UthandoUser\Service\Factory\AclFactory',
        'UthandoUser\Navigation'                            => 'UthandoUser\Service\Factory\UserNavigationFactory'
    ],
];