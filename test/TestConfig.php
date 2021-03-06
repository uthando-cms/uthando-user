<?php
return [
    'modules' => [
        'Application',
        'UthandoCommon',
        'UthandoUser',
        'TwbBundle',
    ],
    'module_listener_options' => [
        'config_cache_enabled' => false,
        'cache_dir'            => 'data/cache',
        'module_paths' => [
            './vendor',
            './devmodules',
            './module'
        ],
    ],
    'service_manager' => [
        'use_defaults' => true,
        'invokables' => [
            'ModuleRouteListener' => 'Zend\Mvc\ModuleRouteListener',
        ],
    ],
];