<?php

namespace UthandoUser\Form;

use Zend\Form\Form;

class UserSearch extends Form
{
	public function __construct()
	{
		parent::__construct('Search');
	
		$this->add(array(
			'name' => 'user',
			'attributes' => array(
				'type'  => 'text',
				'placeholder' => 'User:'
			),
			'options' => array(
				'label' => 'User:',
			),
		));
	
		$this->add(array(
			'name' => 'eamil',
			'attributes' => array(
				'type'  => 'email',
				'placeholder' => 'Email:'
			),
			'options' => array(
				'label' => 'Site:',
			),
		));
	}
	
}
