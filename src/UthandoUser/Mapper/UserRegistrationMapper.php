<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Mapper
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Mapper;

use UthandoCommon\Mapper\AbstractDbMapper;

/**
 * Class UserRegistration
 *
 * @package UthandoUser\Mapper
 */
class UserRegistrationMapper extends AbstractDbMapper
{
    protected $table = 'userRegistration';
    protected $primary = 'userRegistrationId';
}
