<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\InputFilter
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */
namespace UthandoUser\InputFilter;

use Zend\InputFilter\InputFilter;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\Validator\Hostname;

/**
 * Class User
 * @package UthandoUser\InputFilter
 */
class User extends InputFilter implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
	
	public function init()
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

	    $this->add([
	        'name'       => 'email',
	        'required'   => true,
	        'filters'    => [
	            ['name'    => 'StripTags'],
	            ['name'    => 'StringTrim'],
	        ],
	        'validators' => [
	            ['name' => 'EmailAddress', 'options' => [
	                'allow'            => Hostname::ALLOW_DNS,
	                'useMxCheck'       => true,
	                'useDeepMxCheck'   => true
	            ]],
	        ],
	    ]);
	}
	
	public function addEmailNoRecordExists($exclude = null)
	{
	    $exclude = (!$exclude) ?: [
            'field' => 'email',
            'value' => $exclude,
        ];

	    $this->get('email')
	       ->getValidatorChain()
	       ->attachByName('Zend\Validator\Db\NoRecordExists', [
                'table'     => 'user',
                'field'     => 'email',
                'adapter'   => $this->getServiceLocator()->getServiceLocator()->get('Zend\Db\Adapter\Adapter'),
                'exclude'   => $exclude,
            ]);
	    
	    return $this;
	}
}
