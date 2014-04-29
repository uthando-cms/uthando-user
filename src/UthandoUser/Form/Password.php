<?php
namespace UthandoUser\Form;

use Zend\Form\Form;

class Password extends Form
{
    public function __construct()
    {
        parent::__construct('Password');
        
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
    }
}
