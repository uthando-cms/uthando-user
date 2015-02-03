<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Model
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */
namespace UthandoUser\Model;

use UthandoCommon\Model\ModelInterface;
use UthandoCommon\Model\Model;
use Zend\Math\Rand;

/**
 * Class UserRegistration
 * @package UthandoUser\Model
 */
class UserRegistration implements ModelInterface
{
    use Model,
        UserIdTrait,
        UserTrait;
    
    const REQUEST_KEY_LENGTH = 16;

    /**
     * @var string
     */
    protected $token;
    
    /**
     * @var \DateTime
     */
    protected $requestTime;
    
    /**
     * @var bool
     */
    protected $responded = false;
    
    /**
     * @return string $token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }
    
    /**
     * generate a fresh token
     */
    public function generateToken()
    {
        $this->setToken(Rand::getString(
            self::REQUEST_KEY_LENGTH,
            'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'    
        ));
    }

    /**
     * @return DateTime $requestTime
     */
    public function getRequestTime()
    {
        return $this->requestTime;
    }

    /**
     * @param DateTime $requestTime
     * @return $this
     */
    public function setRequestTime(\DateTime $requestTime = null)
    {
        $this->requestTime = $requestTime;
        return $this;
    }

    /**
     * @return boolean $responded
     */
    public function getResponded()
    {
        return $this->responded;
    }

    /**
     * @param boolean $responded
     * @return $this
     */
    public function setResponded($responded)
    {
        $this->responded = $responded;
        return $this;
    }
}
