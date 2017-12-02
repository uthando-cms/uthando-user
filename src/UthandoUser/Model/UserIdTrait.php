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
 * Class UserId
 *
 * @package UthandoUser\Model
 */
trait UserIdTrait
{
    /**
     * @var int
     */
    protected $userId;

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): ModelInterface
    {
        $this->userId = $userId;
        return $this;
    }
}
