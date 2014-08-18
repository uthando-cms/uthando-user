<?php
namespace UthandoUser\Service\Factory;

use UthandoUser\Service\Acl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AclFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $config = $sm->get('config');
        $config = $config['uthando_user'];
        
        $aclRules = (array_key_exists('acl', $config)) ? $config['acl'] : [];
        
        $acl = new Acl($aclRules);
        
        return $acl;
    }
}
