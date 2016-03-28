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
use Zend\Form\Form;

/**
 * Class User
 *
 * @package UthandoUser\Form
 */
class BaseUser extends Form
{
    public function __construct($name = null, array $options =[])
    {
        if (is_array($name)) {
            $options = $name;
            $name = (isset($name['name'])) ? $name['name'] : null;
        }

        parent::__construct($name, $options);
    }

    public function init()
    {
        $this->add([
            'name' => 'active',
            'type' => 'checkbox',
            'options' => [
                'label' => 'Active',
                'use_hidden_element' => true,
                'checked_value' => 1,
                'unchecked_value' => 0,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ],
        ]);

        $this->add([
            'name' => 'firstname',
            'type' => 'text',
            'attributes' => [
                'placeholder' => 'First name',
                'autofocus' => true,
                'autocapitalize' => 'words',
            ],
            'options' => [
                'label' => 'Forename',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'lastname',
            'type' => 'text',
            'attributes' => [
                'placeholder' => 'Last name',
                'autocapitalize' => 'words',
            ],
            'options' => [
                'label' => 'Surname',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'email',
            'type' => 'email',
            'attributes' => [
                'placeholder' => 'Email address',
            ],
            'options' => [
                'label' => 'Email',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'show-password',
            'type' => 'checkbox',
            'options' => [
                'label' => 'Show Password',
                'checked_value' => 1,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ],
            'attributes' => [
                'id' => 'showPassword',
            ],
        ]);

        $this->add([
            'name' => 'passwd',
            'type' => 'password',
            'attributes' => [
                'id' => 'password',
                'placeholder' => 'Password',
            ],
            'options' => [
                'label' => 'Password',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'passwd-confirm',
            'type' => 'password',
            'attributes' => [
                'placeholder' => 'Confirm password',
            ],
            'options' => [
                'label' => 'Confirm Password',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'role',
            'type' => 'UthandoUserRoleList',
            'options' => [
                'label' => 'Role',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'dateCreated',
            'type' => 'DateTime',
            'options' => [
                'label' => 'Date Created',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'format' => 'd/m/Y H:i:s'
            ],
            'attributes' => [
                'disabled' => true,
            ]
        ]);

        $this->add([
            'name' => 'dateModified',
            'type' => 'DateTime',
            'options' => [
                'label' => 'Date Modified',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'format' => 'd/m/Y H:m:s'
            ],
            'attributes' => [
                'disabled' => true,
            ],
        ]);

        $this->add([
            'name' => 'userId',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'security',
            'type' => 'csrf',
        ]);

        $this->add([
            'name' => 'returnTo',
            'type' => 'hidden',
        ]);
    }

    public function addCaptcha()
    {
        $this->add([
            'name' => 'captcha',
            'type' => 'UthandoCommonCaptcha',
            'attributes' => [
                'placeholder' => 'Type letters and number here',
            ],
            'options' => [
                'label' => 'Please verify you are human.',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
                'label_attributes' => [
                    'class' => 'col-sm-10 col-sm-offset-2',
                ],
            ],
        ]);
    }
}
