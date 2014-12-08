<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 * 
 * @package   UthandoUser\Form
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoUser\Form;

use UthandoUser\InputFilter\User as UserInputFilter;

/**
 * Class Login
 * @package UthandoUser\Form
 */
class Login extends User
{
    public function init()
    {
        parent::init();

        $this->remove('userId')
            ->remove('firstname')
            ->remove('lastname')
            ->remove('passwd-confirm')
            ->remove('role')
            ->remove('dateCreated')
            ->remove('dateModified');
    }

    public function getInputFilter()
    {
        $inputFilter = new UserInputFilter();
        $inputFilter->remove('firstname')
            ->remove('lastname')
            ->remove('passwd-confirm');
        return $inputFilter;
    }
} 