<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Options
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Option;

use Zend\Stdlib\AbstractOptions;

class LoginOptions extends AbstractOptions
{
    /**
     * @var int
     */
    protected $registerMinPasswordLength;

    /**
     * @var int
     */
    protected $registerMaxPasswordLength;

    /**
     * @var int
     */
    protected $loginMinPasswordLength;

    /**
     * @var int
     */
    protected $loginMaxPasswordLength;

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
}