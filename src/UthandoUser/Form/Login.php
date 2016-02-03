<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Form
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;

/**
 * Class Login
 *
 * @package UthandoUser\Form
 */
class Login extends BaseUser
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
            ->remove('dateModified')
            ->remove('active');

        $this->add([
            'name' => 'rememberme',
            'type' => 'checkbox',
            'options' => [
                'label' => 'Remember Me',
                'use_hidden_element' => true,
                'checked_value' => 1,
                'unchecked_value' => 0,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'options' => [
                'label' => 'Login',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ]
        ]);
    }
}
