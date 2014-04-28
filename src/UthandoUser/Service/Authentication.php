<?php
namespace UthandoUser\Service;

use UthandoUser\Model\User as UserModel;
use UthandoUser\Service\User;
use Zend\Authentication\AuthenticationService as ZendAuthenticationService;
use UthandoUser\Authentication\Adapter as AuthAdapter;

class Authentication extends ZendAuthenticationService
{
    /**
     * @var AuthAdapter
     */
    protected $authAdapter;
    
    /**
     * @var User
     */
    protected $userService;
    
    /**
     * @var ZendAuthenticationService
     */
    protected $auth;
    
    /**
     * Auth options
     */
    protected $options;
    
    /**
     * Set the user mapper
     * 
     * @param User $mapper
     * @return \UthandoUser\Model\Authentication
     */
    public function setUserService(User $service)
    {
        $this->userService = $service;
        return $this;
    }
    
    /**
     * Sets the auth options
     * 
     * @param array $options
     */
    public function setOptions(array $options)
    {
    	$this->options = $options;
    }
    
    /**
     * Authenticate a user
     *
     * @param  string $email
     * @param string $password
     * @return boolean
     */
    public function doAuthentication($email, $password)
    {
        $user = $this->userService->getUserByEmail($email, null, false);
        
        if (!$user) {
            return false;
        }
        
        // hash the password and verify.
        
    	$adapter    = $this->getAuthAdapter($password, $user);
    	$result     = $this->authenticate($adapter);
    
    	if (!$result->isValid()) {
    		return false;
    	}
    	
    	/* @var $user UserModel */
    	$user = $result->getIdentity();
    	
    	if (in_array('update password', $result->getMessages())) {
    		$user->setPasswd($password);
    		$user->setDateModified();
    		$this->userService->save($user);
    	}
    	
    	$user->setPasswd(null);

    	$this->getStorage()->write($user);
    
    	return true;
    }
    
    /**
     * Clear any authentication data
     */
    public function clear()
    {
    	$this->clearIdentity();
    }
    
    /**
     * Set the auth adpater.
     *
     * @param AuthAdapter $adapter
     */
    public function setAuthAdapter(AuthAdapter $adapter)
    {
    	$this->authAdapter = $adapter;
    }
    
    /**
     * Get and configure the auth adapter
     *
     * @param  string $email
     * @param string $password
     * @param UserModel $user
     * @return AuthAdapter
     */
    public function getAuthAdapter($password, UserModel $user)
    {
    	if (null === $this->authAdapter) {
    	    
    		$authAdapter = new AuthAdapter();
            
    		$this->setAuthAdapter($authAdapter);
    		$this->authAdapter->setIdentity($user);
    		$this->authAdapter->setCredential($password);
    		$this->authAdapter->setCredentialTreatment($this->options['credentialTreatment']);
    		
    		if ($this->options['useFallbackTreatment']) {
    		    $this->authAdapter->setUseFallback($this->options['useFallbackTreatment']);
    		    $this->authAdapter->setFallbackCredentialTreatment($this->options['fallbackCredentialTreatment']);
    		}
    	}
    
    	return $this->authAdapter;
    }
}