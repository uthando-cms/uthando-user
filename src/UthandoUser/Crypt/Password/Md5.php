<?php
namespace UthandoUser\Crypt\Password;

use Zend\Crypt\Password\PasswordInterface;

class Md5 implements PasswordInterface
{
    public function verify($password, $hash)
    {
    	$result = $this->create($password);
    	
    	if ($hash === $result) {
    	    return true;
    	}
    	
    	return false;
    }

    public function create($password)
    {
    	return md5($password);
    }
}
