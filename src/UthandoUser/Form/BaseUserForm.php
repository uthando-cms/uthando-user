<?php declare(strict_types=1);
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
use UthandoCommon\Form\Element\Captcha;
use UthandoUser\Form\Element\RoleList;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\DateTime;
use Zend\Form\Element\Email;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Password;
use Zend\Form\Element\Text;
use Zend\Form\Form;

/**
 * Class User
 *
 * @package UthandoUser\Form
 */
class BaseUserForm extends Form
{
    public function __construct($name = null, array $options =[])
    {
        if (is_array($name)) {
            $options = $name;
            $name = (isset($name['name'])) ? $name['name'] : null;
        }

        parent::__construct($name, $options);
    }

    public function init(): void
    {
        $this->add([
            'name' => 'active',
            'type' => Checkbox::class,
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
            'type' => Text::class,
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
            'type' => Text::class,
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
            'type' => Email::class,
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
            'type' => Checkbox::class,
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
            'type' => Password::class,
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
            'type' => Password::class,
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
            'type' => RoleList::class,
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
            'type' => DateTime::class,
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
            'type' => DateTime::class,
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
            'type' => Hidden::class,
        ]);

        $this->add([
            'name' => 'security',
            'type' => Csrf::class,
        ]);

        $this->add([
            'name' => 'returnTo',
            'type' => Hidden::class,
        ]);
    }

    public function addCaptcha(): void
    {
        $this->add([
            'name' => 'captcha',
            'type' => Captcha::class,
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
