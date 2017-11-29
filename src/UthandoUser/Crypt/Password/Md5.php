<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Crypt\Password
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
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
    public function verify($password, $hash): bool
    {
        $result = $this->create($password);

        if ($hash === $result) {
            return true;
        }

        return false;
    }

    public function create($password): string
    {
        return md5($password);
    }
}
