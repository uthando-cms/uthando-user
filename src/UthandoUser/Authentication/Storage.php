<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Authentication
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2015 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Authentication;

use Zend\Authentication\Storage\Session;

/**
 * Class Storage
 *
 * @package UthandoUser\Authentication
 */
class Storage extends Session
{
    public function rememberMe(int $rememberMe = 0, int $time = 1209600): void
    {
        if ($rememberMe == 1) {
            ini_set('session.gc_maxlifetime', (string) $time);

            $this->session->getManager()->rememberMe($time);
        }
    }

    public function forgetMe(): void
    {
        $this->session->getManager()->forgetMe();
    }
}