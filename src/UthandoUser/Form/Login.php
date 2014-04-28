<?php
namespace UthandoUser\Form;

use Zend\Form\Form;

class Login extends Form
{
    public function __construct()
    {
    	parent::__construct('Login');
    
    	$this->add(array(
			'name' => 'email',
			'type'  => 'email',
			'attributes' => array(
				'placeholder' => 'Email:',
				'required' => true,
				'autofocus' => true
			),
			'options' => array(
				'label' => 'Email:',
			),
    	));
    
    	$this->add(array(
			'name' => 'passwd',
			'type'  => 'password',
			'attributes' => array(
				'placeholder' => 'Password:',
				'required' => true
			),
			'options' => array(
				'label' => 'Password:',
			),
    	));
    	
    	$this->add(array(
    		'name'    => 'security',
    	    'type'    => 'csrf',
    	));
    	
    	$this->add(array(
    	    'name' => 'returnTo',
    	    'type' => 'hidden',
    	));
    }
}
