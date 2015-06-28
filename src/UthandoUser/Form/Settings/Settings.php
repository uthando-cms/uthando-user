<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Form\Settings
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoUser\Form\Settings;

use Zend\Form\Form;

/**
 * Class Settings
 *
 * @package UthandoUser\Form\Settings
 */
class Settings extends Form
{
    public function init()
    {
        $this->add([
            'type' => 'UthandoUserFieldSet',
            'name' => 'user_options',
            'attributes' => [
                'class' => 'col-md-6',
            ],
            'options' => [
                'label' => 'User Options',
            ],
        ]);

        $this->add([
            'type' => 'UthandoUserAuthFieldSet',
            'name' => 'auth',
            'attributes' => [
                'class' => 'col-md-6',
            ],
            'options' => [
                'label' => 'Authentication Options',
            ],
        ]);

        $this->add([
            'name' => 'button-submit',
            'type' => 'button',
            'attributes' => [
                'type' => 'submit',
                'class' => 'btn-primary'
            ],
            'options' => [
                'label' => 'Save',
                'column-size' => 'md-10 col-md-offset-2'
            ],
        ]);
    }
}