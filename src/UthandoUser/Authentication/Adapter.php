<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Authentication
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoUser\Authentication;

use UthandoUser\Model\User as UserModel;
use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Result as AuthenticationResult;

/**
 * Class Adapter
 *
 * @package UthandoUser\Authentication
 */
class Adapter extends AbstractAdapter
{
    /**
     * @var UserModel
     */
    protected $identity;
    
    /**
     * @var string
     */
    protected $credentialTreatment;
    
    /**
     * @var string
     */
    protected $fallbackCredentialTreatment;
    
    /**
     * @var bool
     */
    protected $useFallback = false;

    /**
     * @return AuthenticationResult
     */
    public function authenticate()
    {
        $messages = [];
        
        if ($this->verifyPassword(false)) {
            $code       = AuthenticationResult::SUCCESS;
            $messages[] = 'Authentication successful.';
        } elseif ($this->getUseFallback() && $this->verifyPassword(true)) {
            $code       = AuthenticationResult::SUCCESS;
            $messages[] = 'Authentication successful.';
            $messages[] = 'update password';
        } else {
            $code       = AuthenticationResult::FAILURE;
            $messages[] = 'Authentication failed.';
        }
        
        return new AuthenticationResult(
            $code,
            $this->getIdentity(),
            $messages
        );
    }

    /**
     * @param $useFallback
     * @return bool
     */
    public function verifyPassword($useFallback)
    {
        if ($useFallback === false) {
            $class = new $this->credentialTreatment;
        } else {
            $class = new $this->fallbackCredentialTreatment;
        }
        
        try {
            $verified = $class->verify(
                $this->getCredential(),
                $this->getIdentity()->getPasswd()
            );
        } catch (\Exception $e) {
            $verified = false;
        }
    
        return  $verified;
    }

    /**
     * @return string
     */
    public function getCredentialTreatment()
    {
        return $this->credentialTreatment;
    }

    /**
     * @param $credentialTreatment
     * @return $this
     */
    public function setCredentialTreatment($credentialTreatment)
    {
        $this->credentialTreatment = $credentialTreatment;
        return $this;
    }

    /**
     * @return string
     */
    public function getFallbackCredentialTreatment()
    {
        return $this->fallbackCredentialTreatment;
    }

    /**
     * @param $fallbackCredentialTreatment
     * @return $this
     */
    public function setFallbackCredentialTreatment($fallbackCredentialTreatment)
    {
        $this->fallbackCredentialTreatment = $fallbackCredentialTreatment;
        return $this;
    }

    /**
     * @return bool
     */
    public function getUseFallback()
    {
        return $this->useFallback;
    }

    /**
     * @param $useFallback
     * @return $this
     */
    public function setUseFallback($useFallback)
    {
        $this->useFallback = (bool) $useFallback;
        return $this;
    }
}
