<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Form
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */
namespace UthandoUser\Form;

use Zend\Form\Form;

/**
 * Class User
 * @package UthandoUser\Form
 */
class User extends Form
{
	public function init()
	{
		$this->add([
			'name' => 'userId',
			'type' => 'hidden',
		]);
		
		$this->add([
			'name' => 'firstname',
			'type'  => 'text',
			'attributes' => [
				'placeholder'    => 'First name:',
				'autofocus'      => true,
			    'autocapitalize' => 'words',
                'required'       => true,
			],
			'options' => [
				'label' => 'Forename:',
			],
		]);
		
		$this->add([
			'name' => 'lastname',
			'type'  => 'text',
			'attributes' => [
				'placeholder'    => 'Last name:',
			    'autocapitalize' => 'words',
                'required'       => true,
			],
			'options' => [
				'label' => 'Surname:',
			],
		]);
		
		$this->add([
			'name' => 'email',
			'type'  => 'email',
			'attributes' => [
				'placeholder'   => 'Email address',
                'required'      => true
			],
			'options' => [
				'label' => 'Email:',
			],
		]);
		
		$this->add([
			'name' => 'passwd',
			'type' => 'password',
			'attributes' => [
				'id'			=> 'password',
				'placeholder' 	=> 'Password',
                'required'      => true,
			],
			'options' => [
				'label' => 'Password:',
			],
		]);
		
		$this->add([
		    'name' => 'passwd-confirm',
		    'type' => 'password',
		    'attributes' => [
		        'placeholder' 	=> 'Confirm password',
                'required'      => true,
		    ],
		    'options' => [
		        'label' => 'Confirm Password:',
		    ],
		]);
		
		$this->add([
			'name' => 'role',
			'type'  => 'UthandoUserRoleList',
			'options' => [
				'label' => 'Role:',
			],
		]);
		
		$this->add([
		    'name' => 'active',
		    'type' => 'checkbox',
		    'options' => [
		        'label' => 'Active:',
		        'use_hidden_element'  => true,
		        'checked_value'       => 1,
		        'unchecked_value'     => 0
		    ],
		]);
		
		$this->add([
			'name' => 'dateCreated',
			'type' => 'hidden',
		]);
		
		$this->add([
			'name' => 'dateModified',
			'type' => 'hidden',
		]);
		
		$this->add([
			'name'    => 'security',
			'type'    => 'csrf',
		]);
		
		$this->add([
			'name' => 'returnTo',
		    'type' => 'hidden',
		]);
	}
	
	public function addCaptcha()
	{
	    $this->add([
	        'name' => 'captcha',
	        'type' => 'UthandoCommonCaptcha',
	        'attributes' => [
	            'placeholder' => 'Type letters and number here',
	            'required' => true,
	            'class' => 'form-control',
	        ],
	        'options' => [
	            'label' => 'Please verify you are human.'
	        ],
	    ]);
	}
}
