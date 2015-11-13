<?php

return [
    'navigation' => [
        'default' => [
            'login' => [
                'label'     => 'Sing In',
                'action'    => 'login',
                'route'     => 'user',
                'resource'  => 'menu:guest',
            ],
            'logout' => [
                'label'     => 'Sign Out',
                'action'    => 'logout',
                'route'     => 'user',
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
                    'user-settings' => [
                        'label' => 'Settings',
                        'action' => 'index',
                        'route' => 'admin/user/settings',
                        'resource' => 'menu:admin',
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
                'route'     => 'user',
                'resource'  => 'menu:user',
            ],
            'password' => [
                'label'     => 'Password',
                'action'    => 'password',
                'route'     => 'user',
                'resource'  => 'menu:user',
            ],
            'logout' => [
                'label'    => 'Logout',
                'action'   => 'logout',
                'route'    => 'user',
                'resource' => 'menu:user',
            ],
        ],
    ],
];
