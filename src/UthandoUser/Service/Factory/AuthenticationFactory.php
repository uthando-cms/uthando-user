<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Service\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Service\Factory;

use UthandoUser\Service\Authentication;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AuthenticationFactory
 *
 * @package UthandoUser\Service\Factory
 */
class AuthenticationFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $service = $sm->get('UthandoServiceManager')->get('UthandoUser');
        $storage = $sm->get('UthandoUser\Authentication\Storage');
        $options = $sm->get('UthandoUser\Options\Auth');

        $auth = new Authentication();

        $auth->setUserService($service);
        $auth->setOptions($options);
        $auth->setStorage($storage);

        return $auth;
    }
}
