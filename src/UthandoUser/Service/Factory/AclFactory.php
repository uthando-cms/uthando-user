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

use UthandoUser\Options\UserOptions;
use UthandoUser\Service\Acl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AclFactory
 *
 * @package UthandoUser\Service\Factory
 */
class AclFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm): Acl
    {
        $config     = $sm->get('config');
        $config     = $config['uthando_user'];
        /* @var $options UserOptions */
        $options    = $sm->get(UserOptions::class);

        $aclRules = (array_key_exists('acl', $config)) ? $config['acl'] : [];

        $acl = new Acl($aclRules, $options);

        return $acl;
    }
}
