<?php
namespace UthandoUser\InputFilter;

use Zend\InputFilter\InputFilter;

class Password extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name'       => 'passwd',
            'required'   => true,
            'filters'    => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                ['name' => 'StringLength', 'options' => [
                    'min'       => 8,
                    'encoding'  => 'UTF-8',
                ]],
            ],
        ]);
        
        $this->add([
            'name'       => 'passwd-confirm',
            'required'   => true,
            'filters'    => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                ['name' => 'Identical', 'options' => [
                    'token' => 'passwd',
                ]],
            ],
        ]);
    }
}
