<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Service;

use Zend\Permissions\Acl\AclInterface;

/**
 * Interface AclAwareInterface
 *
 * @package UthandoUser\Service
 */
interface AclAwareInterface
{
    public function setAcl(AclInterface $acl = null);

    public function getAcl();

    //public function setRole($role = null);
    //public function getRole();
}
