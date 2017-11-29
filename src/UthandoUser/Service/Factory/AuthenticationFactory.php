<?php declare(strict_types=1);
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

use UthandoCommon\Service\ServiceManager;
use UthandoUser\Authentication\Storage;
use UthandoUser\Options\AuthOptions;
use UthandoUser\Service\Authentication;
use UthandoUser\Service\User;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AuthenticationFactory
 *
 * @package UthandoUser\Service\Factory
 */
class AuthenticationFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm): Authentication
    {
        $service = $sm->get(ServiceManager::class)->get(User::class);
        $storage = $sm->get(Storage::class);
        $options = $sm->get(AuthOptions::class);

        $auth = new Authentication();

        $auth->setUserService($service);
        $auth->setOptions($options);
        $auth->setStorage($storage);

        return $auth;
    }
}
