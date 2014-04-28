<?php

return [
    'invokables' => [
        'UthandoUser\Controller\Admin'  => 'UthandoUser\Controller\AdminController',
        'UthandoUser\Controller\User'   => 'UthandoUser\Controller\UserController'
    ],
    'factories' => [
        'UthandoUser\Controller\Auth'   => 'UthandoUser\Service\Factory\AuthControllerFactory'
    ]
];