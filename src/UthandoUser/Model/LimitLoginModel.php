<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 04/12/17 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoUser\Model;


use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

class LimitLoginModel implements ModelInterface
{
    use Model;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $ip;

    /**
     * @var int
     */
    protected $attempts;

    /**
     * @var int
     */
    protected $attemptTime;

    /**
     * @var int
     */
    protected $lockedTime;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): LimitLoginModel
    {
        $this->id = $id;
        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): LimitLoginModel
    {
        $this->ip = $ip;
        return $this;
    }

    public function getAttempts(): ?int
    {
        return $this->attempts;
    }

    public function setAttempts(int $attempts): LimitLoginModel
    {
        $this->attempts = $attempts;
        return $this;
    }

    public function getAttemptTime(): ?int
    {
        return $this->attemptTime;
    }

    public function setAttemptTime(int $attemptTime): LimitLoginModel
    {
        $this->attemptTime = $attemptTime;
        return $this;
    }

    public function getLockedTime(): ?int
    {
        return $this->lockedTime;
    }

    public function setLockedTime(int $lockedTime): LimitLoginModel
    {
        $this->lockedTime = $lockedTime;
        return $this;
    }
}
