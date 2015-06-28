<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Crypt\Password
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoUser\Crypt\Password;

use Zend\Crypt\Password\PasswordInterface;

/**
 * Class Md5
 *
 * @package UthandoUser\Crypt\Password
 */
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
