<?php
namespace UthandoUser\Service;

use Zend\Permissions\Acl\AclInterface;

interface AclAwareInterface
{
    public function setAcl(AclInterface $acl = null);
    public function getAcl();
    
    //public function setRole($role = null);
    //public function getRole();
}
