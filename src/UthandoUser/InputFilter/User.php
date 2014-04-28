<?php
namespace UthandoUser\InputFilter;

use Zend\InputFilter\InputFilter;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\Validator\Hostname;

class User extends InputFilter implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
	public function __construct()
	{
		$this->add(array(
            'name'       => 'firstname',
            'required'   => true,
            'filters'    => array(
                array('name'    => 'StripTags'),
                array('name'    => 'StringTrim'),
            ),
            'validators' => array(
                array('name' => 'Alpha', 'options' => array(
                    'allowWhiteSpace' => true,
                )),
                array('name'    => 'StringLength', 'options' => array(
                    'encoding' => 'UTF-8',
                    'min'      => 2,
                    'max'      => 255,
                )),
            ),
        ));
		
		$this->add(array(
            'name'       => 'lastname',
            'required'   => true,
            'filters'    => array(
                array('name'    => 'StripTags'),
                array('name'    => 'StringTrim'),
            ),
            'validators' => array(
                array('name' => 'Alpha', 'options' => array(
                    'allowWhiteSpace' => true,
                )),
                array('name'    => 'StringLength', 'options' => array(
                    'encoding' => 'UTF-8',
                    'min'      => 2,
                    'max'      => 255,
                )),
            ),
        ));
		
		$this->add(array(
            'name'       => 'passwd',
            'required'   => true,
            'filters'    => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
		    'validators' => array(
		        array('name' => 'StringLength', 'options' => array(
		            'min'       => 8,
		            'encoding'  => 'UTF-8',
		        )),
            ),
        ));
		
		$this->add(array(
		    'name'       => 'passwd-confirm',
		    'required'   => true,
		    'filters'    => array(
		        array('name' => 'StripTags'),
		        array('name' => 'StringTrim'),
		    ),
		    'validators' => array(
		    	array('name' => 'Identical', 'options' => array(
                    'token' => 'passwd',
                )),
		    )
		));
	}
	
	public function init()
	{
	    $this->add(array(
	        'name'       => 'email',
	        'required'   => true,
	        'filters'    => array(
	            array('name'    => 'StripTags'),
	            array('name'    => 'StringTrim'),
	        ),
	        'validators' => array(
	            array('name' => 'Zend\Validator\Db\NoRecordExists', 'options' => array(
	                'table'    => 'user',
	                'field'    => 'email',
	                'adapter'  => $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'),
	            )),
	            array('name' => 'EmailAddress', 'options' => array(
	                'allow'            => Hostname::ALLOW_DNS,
	                'useMxCheck'       => true,
	                'useDeepMxCheck'   => true
	            )),
	        )
	    ));
	}
}
