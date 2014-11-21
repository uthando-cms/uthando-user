<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Service\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */
namespace UthandoUser\Service\Factory;

use UthandoUser\Service\Authentication;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AuthenticationFactory
 * @package UthandoUser\Service\Factory
 */
class AuthenticationFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $service = $sm->get('UthandoUser\Service\User');
        $config = $sm->get('config');
        
        $auth = new Authentication();
        
        $auth->setUserService($service);
        $auth->setOptions($config['uthando_user']['auth']);
        
        return $auth;
    }
}
