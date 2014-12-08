<?php

return [
    'invokables' => [
        'UthandoUserLogin'      => 'UthandoUser\Form\Login',
        'UthandoUserRegister'   => 'UthandoUser\Form\Register',
        'UthandoUser'           => 'UthandoUser\Form\User',
        'UthandoUserSearch'     => 'UthandoUser\Form\UserSearch',

        'UthandoUserRoleList'   => 'UthandoUser\Form\Element\RoleList',
        'UthandoUserList'       => 'UthandoUser\Form\Element\UserList',
    ]
];