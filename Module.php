<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */
namespace UthandoUser;

use Zend\Mvc\MvcEvent;
use UthandoUser\Event\MvcListener;

/**
 * Class Module
 * @package UthandoUser
 */
class Module
{
	public function onBootstrap(MvcEvent $event)
	{
		$eventManager = $event->getApplication()->getEventManager();
		$eventManager->attach(new MvcListener());
	}
	
    public function getConfig()
    {
        return include __DIR__ . '/config/config.php';
    }
    
    public function getControllerConfig()
    {
        return include __DIR__ . '/config/controller.config.php';
    }

    public function getFormElementConfig()
    {
        return include __DIR__ . '/config/formElement.config.php';
    }

    public function getHydratorConfig()
    {
        return include __DIR__ . '/config/hydrator.config.php';
    }

    public function getInputFilterConfig()
    {
        return include __DIR__ . '/config/inputFilter.config.php';
    }
    
    public function getControllerPluginConfig()
    {
        return include __DIR__ . '/config/controllerPlugin.config.php';
    }

    public function getServiceConfig()
    {
        return include __DIR__ . '/config/service.config.php';
    }

    public function getViewHelperConfig()
    {
        return include __DIR__ . '/config/viewHelper.config.php';
    }

    public function getUthandoMapperConfig()
    {
        return include __DIR__ . '/config/mapper.config.php';
    }

    public function getUthandoModelConfig()
    {
        return include __DIR__ . '/config/model.config.php';
    }
    
    public function getUthandoServiceConfig()
    {
        return include __DIR__ . '/config/uthandoServices.config.php';
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
