<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Options
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Options;

use Zend\Stdlib\AbstractOptions;
use Zend\Validator\Hostname;

class LoginOptions extends AbstractOptions
{
    /**
     * @var bool
     */
    protected $limitLogin = false;

    /**
     * @var int
     */
    protected $maxLoginAttempts = 3;

    /**
     * @var int
     */
    protected $banTime = 1800;
    /**
     * @var int
     */
    protected $registerMinPasswordLength = 8;

    /**
     * @var int
     */
    protected $registerMaxPasswordLength = 16;

    /**
     * @var int
     */
    protected $loginMinPasswordLength = 8;

    /**
     * @var int
     */
    protected $loginMaxPasswordLength = 16;

    /**
     * @var array
     */
    protected $emailValidateOptions = [
        'useMxCheck'        => false,
        'useDeepMxCheck'    => false,
        'useDomainCheck'    => true,
        'strict'            => true,
        'allow'             => Hostname::ALLOW_DNS,
    ];

    public function getLimitLogin(): bool
    {
        return $this->limitLogin;
    }

    public function setLimitLogin(bool $limitLogin): LoginOptions
    {
        $this->limitLogin = $limitLogin;
        return $this;
    }

    public function getMaxLoginAttempts(): int
    {
        return $this->maxLoginAttempts;
    }

    public function setMaxLoginAttempts(int $maxLoginAttempts): LoginOptions
    {
        $this->maxLoginAttempts = $maxLoginAttempts;
        return $this;
    }

    public function getBanTime(): int
    {
        return $this->banTime;
    }

    public function setBanTime(int $banTime): LoginOptions
    {
        $this->banTime = $banTime;
        return $this;
    }

    public function getRegisterMinPasswordLength(): ?int
    {
        return $this->registerMinPasswordLength;
    }

    public function setRegisterMinPasswordLength(int $registerMinPasswordLength): LoginOptions
    {
        $this->registerMinPasswordLength = $registerMinPasswordLength;
        return $this;
    }

    public function getRegisterMaxPasswordLength(): ?int
    {
        return $this->registerMaxPasswordLength;
    }

    public function setRegisterMaxPasswordLength(int $registerMaxPasswordLength): LoginOptions
    {
        $this->registerMaxPasswordLength = $registerMaxPasswordLength;
        return $this;
    }

    public function getLoginMinPasswordLength(): ?int
    {
        return $this->loginMinPasswordLength;
    }

    public function setLoginMinPasswordLength(int $loginMinPasswordLength): LoginOptions
    {
        $this->loginMinPasswordLength = $loginMinPasswordLength;
        return $this;
    }

    public function getLoginMaxPasswordLength(): ?int
    {
        return $this->loginMaxPasswordLength;
    }

    public function setLoginMaxPasswordLength(int $loginMaxPasswordLength): LoginOptions
    {
        $this->loginMaxPasswordLength = $loginMaxPasswordLength;
        return $this;
    }

    /**
     * @return array
     */
    public function getEmailValidateOptions(): array
    {
        return $this->emailValidateOptions;
    }

    /**
     * @param array $emailValidateOptions
     * @return LoginOptions
     */
    public function setEmailValidateOptions(array $emailValidateOptions): LoginOptions
    {
        $this->emailValidateOptions = $emailValidateOptions;
        return $this;
    }
}
