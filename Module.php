<?php

namespace UthandoUser;

use Zend\Mvc\MvcEvent;
use UthandoUser\Event\MvcListener;

class Module
{
	public function onBootstrap(MvcEvent $event)
	{
		$eventManager = $event->getApplication()->getEventManager();
		$eventManager->attach(new MvcListener());
	}
	
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
    	return [
            'invokables' => [
                'UthandoUser\InputFilter\User'                      => 'UthandoUser\InputFilter\User',
                'UthandoUser\Mapper\User'                           => 'UthandoUser\Mapper\User',
                'UthandoUser\Service\User'                          => 'UthandoUser\Service\User'
            ],
            'factories' => [
                'Zend\Authentication\AuthenticationService'         => 'UthandoUser\Service\Factory\AuthenticationFactory',
                'UthandoUser\Service\Acl'                           => 'UthandoUser\Service\Factory\AclFactory',
                'UthandoUser\Navigation'                            => 'UthandoUser\Service\Factory\UserNavigationFactory'
            ],
        ];
    }
    
    public function getViewHelperConfig()
    {
        return [
            'invokables' => [
            	'IsAllowed' => 'UthandoUser\View\IsAllowed',
            ], 
        ];
    }
    
    public function getControllerConfig()
    {
        return [
            'invokables' => [
                'UthandoUser\Controller\Admin'  => 'UthandoUser\Controller\AdminController',
                'UthandoUser\Controller\User'   => 'UthandoUser\Controller\UserController'
            ],
        ];
    }
    
    public function getControllerPluginConfig()
    {
        return [
            'invokables' => [
            	'IsAllowed' => 'UthandoUser\Controller\Plugin\IsAllowed'
            ],
        ];
    }
    
    public function getAutoloaderConfig()
    {
    	return [
    		'Zend\Loader\ClassMapAutoloader' => [
    			__DIR__ . '/autoload_classmap.php'
    		],
    	];
    }
}
