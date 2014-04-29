<?php

namespace UthandoUser\Form;

use Zend\Form\Form;

class UserSearch extends Form
{
	public function __construct()
	{
		parent::__construct('Search');
	
		$this->add([
			'name' => 'user',
			'attributes' => [
				'type'  => 'text',
				'placeholder' => 'User:'
			],
			'options' => [
				'label' => 'User:',
			],
		]);
	
		$this->add([
			'name' => 'eamil',
			'attributes' => [
				'type'  => 'email',
				'placeholder' => 'Email:'
			],
			'options' => [
				'label' => 'Site:',
			],
		]);
	}
	
}
