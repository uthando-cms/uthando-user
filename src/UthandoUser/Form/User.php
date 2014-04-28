<?php

namespace UthandoUser\Form;

use Zend\Form\Form;

class User extends Form
{
	public function __construct()
	{
		parent::__construct('User');
		
		$this->add(array(
			'name' => 'userId',
			'type' => 'hidden',
		));
		
		$this->add(array(
			'name' => 'firstname',
			'type'  => 'text',
			'attributes' => array(
				'placeholder'    => 'Forename:',
				'autofocus'      => true,
			    'autocapitalize' => 'words'
			),
			'options' => array(
				'label' => 'Forename:',
			),
		));
		
		$this->add(array(
			'name' => 'lastname',
			'type'  => 'text',
			'attributes' => array(
				'placeholder'    => 'Surname:',
			    'autocapitalize' => 'words'
			),
			'options' => array(
				'label' => 'Surname:',
			),
		));
		
		$this->add(array(
			'name' => 'email',
			'type'  => 'email',
			'attributes' => array(
				'placeholder' => 'Email:',
			),
			'options' => array(
				'label' => 'Email:',
			),
		));
		
		$this->add(array(
			'name' => 'passwd',
			'type' => 'password',
			'attributes' => array(
				'id'			=> 'password',
				'placeholder' 	=> 'Password:',
			),
			'options' => array(
				'label' => 'Password:',
			),
		));
		
		$this->add(array(
		    'name' => 'passwd-confirm',
		    'type' => 'password',
		    'attributes' => array(
		        'placeholder' 	=> 'Repeat Password:',
		    ),
		    'options' => array(
		        'label' => 'Confirm Password:',
		    ),
		));
		
		$this->add(array(
			'name' => 'role',
			'type'  => 'select',
			'attributes' => array(
				'placeholder' => 'Role:',
			),
			'options' => array(
				'label' => 'Role:',
				'empty_option' => 'Please choose a user role',
				'value_options' => array(
					'admin' 		=> 'Admin',
					'registered' 	=> 'Registered',
				),
			),
		));
		
		$this->add(array(
			'name' => 'dateCreated',
			'type' => 'hidden',
		));
		
		$this->add(array(
			'name' => 'dateModified',
			'type' => 'hidden',
		));
		
		$this->add(array(
			'name' => 'returnTo',
		    'type' => 'hidden',
		));
	}
}
