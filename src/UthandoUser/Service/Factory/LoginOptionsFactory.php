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

use UthandoUser\Options\LoginOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LoginOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator): LoginOptions
    {
        $config = $serviceLocator->get('config');
        $userConfig = (isset($config['uthando_user']['login_options'])) ? $config['uthando_user']['login_options'] : [];

        return new LoginOptions($userConfig);
    }
}
