<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Service\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Service\Factory;

use UthandoUser\Options\AuthOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator): AuthOptions
    {
        $config = $serviceLocator->get('config');
        $authOptions = (isset($config['uthando_user']['auth'])) ? $config['uthando_user']['auth'] : [];

        return new AuthOptions($authOptions);
    }
}
