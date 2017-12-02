<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 02/12/17 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoUser\Options;

use Zend\Stdlib\AbstractOptions;

class UserOptions extends AbstractOptions
{
    /**
     * @var bool
     */
    protected $enableUserLogin = true;

    /**
     * @var bool
     */
    protected $enableUserRegister = true;

    public function getEnableUserLogin(): bool
    {
        return $this->enableUserLogin;
    }

    public function setEnableUserLogin(bool $enableUserLogin): UserOptions
    {
        $this->enableUserLogin = $enableUserLogin;
        return $this;
    }

    public function getEnableUserRegister(): bool
    {
        return $this->enableUserRegister;
    }

    public function setEnableUserRegister(bool $enableUserRegister): UserOptions
    {
        $this->enableUserRegister = $enableUserRegister;
        return $this;
    }
}
