<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Model
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Model;

use UthandoCommon\Model\ModelInterface;

/**
 * Class UserTrait
 *
 * @package UthandoUser\Model
 */
trait UserTrait
{
    use UserIdTrait;

    /**
     * @var UserModel
     */
    protected $user;

    public function getUser(): UserModel
    {
        return $this->user;
    }

    public function setUser(UserModel $user): ModelInterface
    {
        $this->user = $user;
        return $this;
    }
}
