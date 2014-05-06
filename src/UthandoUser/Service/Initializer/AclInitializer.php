<?php
namespace UthandoUser\Service\Initializer;

use UthandoUser\Service\AclAwareInterface;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AclInitializer implements InitializerInterface
{
	public function initialize($instance, ServiceLocatorInterface $serviceLocator)
	{
		if ($instance instanceof AclAwareInterface) {
            $acl = $serviceLocator->get('UthandoUser\Service\Acl');
            
            $instance->setAcl($acl);
		}
	}
}
