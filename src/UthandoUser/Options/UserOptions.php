<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Options
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoUser\Option;

use Zend\Stdlib\AbstractOptions;

/**
 * Class UserOptions
 *
 * @package UthandoUser\Options
 */
class UserOptions extends AbstractOptions
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

    /**
     * @return int
     */
    public function getRegisterMinPasswordLength()
    {
        return $this->registerMinPasswordLength;
    }

    /**
     * @param int $registerMinPasswordLength
     * @return $this
     */
    public function setRegisterMinPasswordLength($registerMinPasswordLength)
    {
        $this->registerMinPasswordLength = $registerMinPasswordLength;
        return $this;
    }

    /**
     * @return int
     */
    public function getRegisterMaxPasswordLength()
    {
        return $this->registerMaxPasswordLength;
    }

    /**
     * @param int $registerMaxPasswordLength
     * @return $this
     */
    public function setRegisterMaxPasswordLength($registerMaxPasswordLength)
    {
        $this->registerMaxPasswordLength = $registerMaxPasswordLength;
        return $this;
    }

    /**
     * @return int
     */
    public function getLoginMinPasswordLength()
    {
        return $this->loginMinPasswordLength;
    }

    /**
     * @param int $loginMinPasswordLength
     * @return $this
     */
    public function setLoginMinPasswordLength($loginMinPasswordLength)
    {
        $this->loginMinPasswordLength = $loginMinPasswordLength;
        return $this;
    }

    /**
     * @return int
     */
    public function getLoginMaxPasswordLength()
    {
        return $this->loginMaxPasswordLength;
    }

    /**
     * @param int $loginMaxPasswordLength
     * @return $this
     */
    public function setLoginMaxPasswordLength($loginMaxPasswordLength)
    {
        $this->loginMaxPasswordLength = $loginMaxPasswordLength;
        return $this;
    }
}