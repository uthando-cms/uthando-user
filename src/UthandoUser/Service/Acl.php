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

use Zend\Permissions\Acl\Acl as ZendAcl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

/**
 * Class Acl
 *
 * @package UthandoUser\Service
 */
class Acl extends ZendAcl
{
    /**
     * An array of user roles.
     *
     * @var array
     */
    protected $userRoles = [];
    
    /**
     * An array of resources.
     *
     * @var array
    */
    protected $userResources = [];
    
    /**
     * allow rules
     * 
     * @var array
     */
    protected $allowRules = [];
    
    /**
     * deny rules
     * 
     * @var unknown
     */
    protected $denyRules = [];
    
    
    /**
     * Set up role and resouces for power module.
    */
    public function __construct(array $config)
    {
    	// block all by default.
    	$this->deny();
    	//$this->allow();
    
    	if (isset($config['roles'])) {
    		$this->userRoles = $config['roles'];
    	}
    
    	if (isset($config['resources'])) {
    		$this->userResources = $config['resources'];
    	}
    
    	// add resources.
    	foreach ($this->userResources as $value) {
    		$this->addResource(new Resource($value));
    	}
    
    	foreach ($this->userRoles as $role => $values) {
    		$this->addRole(new Role($role), $values['parent']);
    		
    		foreach ($values['privileges'] as $action => $privileges) {
    		    if ('allow' === $action) {
    		        $this->allowRules[$role] = $privileges;
    		    }
    		    
    		    if ('deny' === $action) {
    		        $this->denyRules[$role] = $privileges;
    		    }
    		}
    	}
    	
    	// set up allow rules.
    	// TODO: this needs serious rethinking...
    	foreach ($this->allowRules as $role => $privileges) {
    	   foreach ($privileges as $key => $value) {
    	        if ('resources' === $key) {
    	            foreach ($value as $resource) {
    	                $this->allow($role, $resource);
    	            }
    	        }
    	        
    	        if ('controllers' === $key) {
    	            foreach ($value as $controller => $actions) {
    	                if (is_string($actions['action']) && 'all' === $actions['action']) {
    	                	$this->allow($role, $controller);
    	                } else {
    	                	$this->allow($role, $controller, $actions['action']);
    	                }
    	            }
                }
            }
    	}
    	
    	// set up deny rules.
    	foreach ($this->denyRules as $role => $privileges) {
    	    foreach ($privileges as $key => $value) {
    	        if ('resources' === $key) {
    	           foreach ($value as $resource) {
    	                $this->deny($role, $resource);
    	            }
    	        }
    	        
    	        if ('controllers' === $key) {
    	            foreach ($value as $controller => $actions) {
    	                if (is_string($actions['action']) && 'all' === $actions['action']) {
    	                	$this->deny($role, $controller);
    	                } else {
    	                	$this->deny($role, $controller, $actions['action']);
    	                }
    	            }
                }
            }
    	}
    }
}
