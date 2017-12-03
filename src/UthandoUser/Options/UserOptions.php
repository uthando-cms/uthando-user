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
    protected $disableUserLogin = true;

    /**
     * @var bool
     */
    protected $disableUserRegister = true;

    public function getDisableUserLogin(): bool
    {
        return $this->disableUserLogin;
    }

    public function setDisableUserLogin(bool $disableUserLogin): UserOptions
    {
        $this->disableUserLogin = $disableUserLogin;
        return $this;
    }

    public function getDisableUserRegister(): bool
    {
        return $this->disableUserRegister;
    }

    public function setDisableUserRegister(bool $disableUserRegister): UserOptions
    {
        $this->disableUserRegister = $disableUserRegister;
        return $this;
    }
}
