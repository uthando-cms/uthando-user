<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Form\Settings
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Form\Settings;

use Zend\Form\Form;

/**
 * Class Settings
 *
 * @package UthandoUser\Form\Settings
 */
class SettingsForm extends Form
{
    public function init(): void
    {
        $this->add([
            'type' => UserFieldSet::class,
            'name' => 'user_options',
            'attributes' => [
                'class' => 'col-sm-6',
            ],
            'options' => [
                'label' => 'User Options',
            ],
        ]);

        $this->add([
            'type' => LoginFieldSet::class,
            'name' => 'login_options',
            'attributes' => [
                'class' => 'col-sm-6',
            ],
            'options' => [
                'label' => 'Login Options',
            ],
        ]);

        $this->add([
            'type' => AuthFieldSet::class,
            'name' => 'auth',
            'attributes' => [
                'class' => 'col-sm-6',
            ],
            'options' => [
                'label' => 'Authentication Options',
            ],
        ]);
    }
}
