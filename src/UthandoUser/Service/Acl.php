<?php
namespace UthandoUser\Service;

use Zend\Permissions\Acl\Acl as ZendAcl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

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
     * Set up role and resouces for power module.
    */
    public function __construct(array $config)
    {
    	// block all by default.
    	$this->deny();
    
    	if (isset($config['userRoles'])) {
    		$this->userRoles = $config['userRoles'];
    	}
    
    	if (isset($config['userResources'])) {
    		$this->userResources = $config['userResources'];
    	}
    
    	// add resources.
    	foreach ($this->userResources as $value) {
    		$this->addResource(new Resource($value));
    	}
    
    	foreach ($this->userRoles as $role => $values) {
    		$this->addRole(new Role($role), $values['parent']);
    
    		foreach ($values['privileges'] as $value) {
    			if (is_string($value['action']) && 'all' === $value['action']) {
    				$this->allow($role, $value['controller']);
    			} else {
    				$this->allow($role, $value['controller'], $value['action']);
    			}
    		}
    		
    		foreach ($values['resources'] as $value) {
    			$this->allow($role, $value);
    		}
    	}
    }
}
