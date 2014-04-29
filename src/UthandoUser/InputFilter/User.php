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
		$this->add([
            'name'       => 'firstname',
            'required'   => true,
            'filters'    => [
                ['name'    => 'StripTags'],
                ['name'    => 'StringTrim'],
            ],
            'validators' => [
                ['name' => 'Alpha', 'options' => [
                    'allowWhiteSpace' => true,
                ]],
                ['name'    => 'StringLength', 'options' => [
                    'encoding' => 'UTF-8',
                    'min'      => 2,
                    'max'      => 255,
                ]],
            ],
        ]);
		
		$this->add([
            'name'       => 'lastname',
            'required'   => true,
            'filters'    => [
                ['name'    => 'StripTags'],
                ['name'    => 'StringTrim'],
            ],
            'validators' => [
                ['name' => 'Alpha', 'options' => [
                    'allowWhiteSpace' => true,
                ]],
                ['name'    => 'StringLength', 'options' => [
                    'encoding' => 'UTF-8',
                    'min'      => 2,
                    'max'      => 255,
                ]],
            ],
        ]);
		
		$this->add([
            'name'       => 'passwd',
            'required'   => true,
            'filters'    => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
		    'validators' => [
		        ['name' => 'StringLength', 'options' => [
		            'min'       => 8,
		            'encoding'  => 'UTF-8',
		        ]],
            ],
        ]);
		
		$this->add([
		    'name'       => 'passwd-confirm',
		    'required'   => true,
		    'filters'    => [
		        ['name' => 'StripTags'],
		        ['name' => 'StringTrim'],
		    ],
		    'validators' => [
		    	['name' => 'Identical', 'options' => [
                    'token' => 'passwd',
                ]],
		    ],
		]);
	}
	
	public function init()
	{
	    $this->add([
	        'name'       => 'email',
	        'required'   => true,
	        'filters'    => [
	            ['name'    => 'StripTags'],
	            ['name'    => 'StringTrim'],
	        ],
	        'validators' => [
	            ['name' => 'Zend\Validator\Db\NoRecordExists', 'options' => [
	                'table'    => 'user',
	                'field'    => 'email',
	                'adapter'  => $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'),
	            ]],
	            ['name' => 'EmailAddress', 'options' => [
	                'allow'            => Hostname::ALLOW_DNS,
	                'useMxCheck'       => true,
	                'useDeepMxCheck'   => true
	            ]],
	        ],
	    ]);
	}
}
