<?php
namespace UthandoUser\Form;

use Zend\Form\Form;

class Login extends Form
{
    public function __construct()
    {
    	parent::__construct('Login');
    
    	$this->add([
			'name' => 'email',
			'type'  => 'email',
			'attributes' => [
				'placeholder' => 'Email:',
				'required' => true,
				'autofocus' => true
			],
			'options' => [
				'label' => 'Email:',
			],
    	]);
    
    	$this->add([
			'name' => 'passwd',
			'type'  => 'password',
			'attributes' => [
				'placeholder' => 'Password:',
				'required' => true
			],
			'options' => [
				'label' => 'Password:',
			],
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
}
