<?php
namespace UthandoUser\InputFilter;

use Zend\InputFilter\InputFilter;

class Login extends InputFilter
{
    public function __construct()
    {
    	$this->add([
			'name'       => 'email',
			'required'   => true,
			'filters'    => [
				['name' => 'StripTags'],
				['name' => 'StringTrim'],
			],
    	]);
    
    	$this->add([
			'name'       => 'passwd',
			'required'   => true,
			'filters'    => [
				['name' => 'StripTags'],
				['name' => 'StringTrim'],
			],
    	]);
    }
}
