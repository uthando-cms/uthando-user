<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Form
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Form;


/**
 * Class User
 *
 * @package UthandoUser\Form
 */
class User extends BaseUser
{
    public function init()
    {
        parent::init();

        if (!$this->getOption('include_password')) {
            $this->remove('passwd')
                ->remove('passwd-confirm')
                ->remove('show-password');
        }


    }
}
