<?php
namespace UthandoUser\Authentication;

use UthandoUser\Model\User as UserModel;
use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Result as AuthenticationResult;

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
    
	/* (non-PHPdoc)
     * @see \Zend\Authentication\Adapter\AdapterInterface::authenticate()
     */
    public function authenticate()
    {
        $messages = [];
        
        if ($this->verifyPassword(false)) {
            $code       = AuthenticationResult::SUCCESS;
            $messages[] = 'Authentication successful.';
        } elseif ($this->getUseFallback() && $this->verifyPassword(true)) {
            $code       = AuthenticationResult::SUCCESS;
            $messages[]   = 'Authentication successful.';
            $messages[]   = 'update password';
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
