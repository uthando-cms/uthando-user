<?php
namespace UthandoUser\InputFilter;

use Zend\InputFilter\InputFilter;

class Password extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name'       => 'passwd',
            'required'   => true,
            'filters'    => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array('name' => 'StringLength', 'options' => array(
                    'min'       => 8,
                    'encoding'  => 'UTF-8',
                )),
            ),
        ));
        
        $this->add(array(
            'name'       => 'passwd-confirm',
            'required'   => true,
            'filters'    => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array('name' => 'Identical', 'options' => array(
                    'token' => 'passwd',
                )),
            )
        ));
    }
}
