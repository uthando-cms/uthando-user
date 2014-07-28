<?php
namespace UthandoUser\Controller\Plugin;

use UthandoUser\Model\User;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Role\RoleInterface;

class IsAllowed extends AbstractPlugin
{
    /**
     * @var Zend\Permissions\Acl\Acl
     */
    protected $acl;

    /**
     * @var string
     */
    protected $identity;

    /**
     * Get the current acl
     *
     * @return Zend\Permissions\Acl\Acl
     */
    public function getAcl()
    {
        if (!$this->acl) {
            $acl = $this->getController()
                ->getServiceLocator()
                ->get('UthandoUser\Service\Acl');
            
            $this->acl = $acl;
        }
        
        return $this->acl;
    }

    /**
     * Check the acl
     *
     * @param string $resource
     * @param string $privilege
     * @return boolean
     */
    public function isAllowed($resource = null, $privilege = null)
    {
        if (null === $this->acl) {
            $this->getAcl();
        }

        return $this->acl->isAllowed($this->getIdentity()->getRoleId(), $resource, $privilege);
    }

    /**
     * Set the identity of the current request
     *
     * @param array null|User|Role $identity
     * @return \UthandoUser\Controller\Plugin\Acl
     */
    public function setIdentity($identity)
    { 
        if ($identity instanceof User) {
            $this->identity = $identity;
        } elseif (null === $identity) {
            $this->identity = new Role('guest');
        } elseif (!$identity instanceof RoleInterface) {
            throw new \Exception('Invalid identity provided');
        }

        return $this;
    }

    /**
     * Get the identity
     *
     * @return string
     */
    public function getIdentity()
    {
        if (null === $this->identity) {
            $identity = $this->getController()->plugin('identity');
            $this->setIdentity($identity());
        }

        return $this->identity;
    }

    /**
     * Proxy to the isAllowed method
     */
    public function __invoke($resource = null, $privilege = null)
    {
        return $this->isAllowed($resource, $privilege);
    }
}
