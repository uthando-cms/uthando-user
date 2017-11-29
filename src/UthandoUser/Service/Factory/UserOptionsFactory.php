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

use UthandoUser\Option\UserOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator): UserOptions
    {
        $config = $serviceLocator->get('config');
        $userConfig = (isset($config['uthando_user']['user_options'])) ? $config['uthando_user']['user_options'] : [];

        return new UserOptions($userConfig);
    }
}
