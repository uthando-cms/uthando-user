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
        return include __DIR__ . '/config/module.config.php';
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
