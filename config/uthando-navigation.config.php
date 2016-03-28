<?php

return [
    'navigation' => [
        'default' => [
            'login' => [
                'label'     => 'Sign In',
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
                'label' => 'Users',
                'action'    => 'index',
                'route'     => 'admin/user',
                'resource'  => 'menu:admin',
                'params' => [
                    'icon' => 'fa-users',
                ],
                'pages' => [
                    'user-settings' => [
                        'label' => 'Settings',
                        'action' => 'index',
                        'route' => 'admin/user/settings',
                        'resource' => 'menu:admin',
                        'visible' => false,
                    ],
                    'edit' => [
                        'label'     => 'Edit User',
                        'action'    => 'edit',
                        'visible'   => false,
                        'route'     => 'admin/user/edit',
                        'resource'  => 'menu:admin'
                    ],
                    'add' => [
                        'label'     => 'Add User',
                        'action'    => 'add',
                        'route'     => 'admin/user/edit',
                        'resource'  => 'menu:admin',
                        'visible'   => false,
                    ],
                ],

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
