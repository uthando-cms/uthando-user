<?php
namespace UthandoUser\Form\Element;

use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

abstract class AbstractResourceList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @var string
     */
    protected $resource;

    /**
     * @var string
     */
    protected $emptyOption = 'None';

    /**
     * @return void
     */
    public function init()
    {
        $config = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('config');

        $resources = $config['uthando_user']['acl']['resources'];

        $regex = '/^' . $this->resource . ':/';
        
        $resources = preg_grep($regex, $resources);
        
        $this->setValueOptions($this->getResources($resources));
    }

    /**
     * @param array $resources
     * @return array
     */
    public function getResources($resources)
    {
    	$routeArray = [];
    	
    	foreach($resources as $val) {
    		$routeArray[$val] = $val;
    	}
    
    	return $routeArray;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param string $resource
     * @return $this
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
        return $this;
    }
}
