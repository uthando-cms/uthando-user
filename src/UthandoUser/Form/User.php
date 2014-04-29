<?php

namespace UthandoUser\Form;

use Zend\Form\Form;

class User extends Form
{
	public function __construct()
	{
		parent::__construct('User');
		
		$this->add([
			'name' => 'userId',
			'type' => 'hidden',
		]);
		
		$this->add([
			'name' => 'firstname',
			'type'  => 'text',
			'attributes' => [
				'placeholder'    => 'Forename:',
				'autofocus'      => true,
			    'autocapitalize' => 'words'
			],
			'options' => [
				'label' => 'Forename:',
			],
		]);
		
		$this->add([
			'name' => 'lastname',
			'type'  => 'text',
			'attributes' => [
				'placeholder'    => 'Surname:',
			    'autocapitalize' => 'words'
			],
			'options' => [
				'label' => 'Surname:',
			],
		]);
		
		$this->add([
			'name' => 'email',
			'type'  => 'email',
			'attributes' => [
				'placeholder' => 'Email:',
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
				'placeholder' 	=> 'Password:',
			],
			'options' => [
				'label' => 'Password:',
			],
		]);
		
		$this->add([
		    'name' => 'passwd-confirm',
		    'type' => 'password',
		    'attributes' => [
		        'placeholder' 	=> 'Repeat Password:',
		    ],
		    'options' => [
		        'label' => 'Confirm Password:',
		    ],
		]);
		
		$this->add([
			'name' => 'role',
			'type'  => 'select',
			'attributes' => [
				'placeholder' => 'Role:',
			],
			'options' => [
				'label' => 'Role:',
				'empty_option' => 'Please choose a user role',
				'value_options' => [
					'admin' 		=> 'Admin',
					'registered' 	=> 'Registered',
				],
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
			'name' => 'returnTo',
		    'type' => 'hidden',
		]);
	}
}
