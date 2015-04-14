<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */
namespace UthandoUser\Service;

use UthandoUser\Model\User as UserModel;
use Zend\Authentication\AuthenticationService as ZendAuthenticationService;
use UthandoUser\Authentication\Adapter as AuthAdapter;

/**
 * Class Authentication
 *
 * @package UthandoUser\Service
 * @method UserModel getIdentity()
 * @method \UthandoUser\Authentication\Storage getStorage()
 */
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
     * Auth options
     */
    protected $options;
    
    /**
     * Set the user mapper
     * 
     * @param User $service
     * @return \UthandoUser\Service\Authentication
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
     * @param  string $identity
     * @param string $password
     * @return boolean
     */
    public function doAuthentication($identity, $password)
    {
        $authMethod = $this->options['AuthenticateMethod'];
        $user = $this->userService->$authMethod($identity, null, false, true);
        
        if (!$user) {
            return false;
        }
        
        // hash the password and verify.
        
    	$adapter    = $this->getAuthAdapter($password, $user);
    	$result     = $this->authenticate($adapter);
    
    	if (!$result->isValid()) {
    		return false;
    	}

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
        $this->getStorage()->forgetMe();
    	$this->clearIdentity();
    }
    
    /**
     * Set the auth adapter.
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