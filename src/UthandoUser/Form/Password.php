<?php
namespace UthandoUser\Form;

use Zend\Form\Form;

class Password extends Form
{
    public function __construct()
    {
        parent::__construct('Password');
        
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
    }
}
