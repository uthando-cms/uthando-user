<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Form\Settings
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Form\Settings;

use UthandoUser\Option\LoginOptions;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Form\Element\Number;
use Zend\Form\Fieldset;
use Zend\Hydrator\ClassMethods;
use Zend\I18n\Validator\IsInt;
use Zend\InputFilter\InputFilterProviderInterface;

/**
 * Class UserFieldSet
 *
 * @package UthandoUser\Form\Settings
 */
class LoginFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setHydrator(new ClassMethods())
            ->setObject(new LoginOptions());
    }

    public function init(): void
    {
        $this->add([
            'name' => 'login_min_password_length',
            'type' => Number::class,
            'options' => [
                'label' => 'Login Min Password Length',
                'column-size' => 'sm-6',
                'label_attributes' => [
                    'class' => 'col-sm-6',
                ],
            ],
        ]);

        $this->add([
            'name' => 'login_max_password_length',
            'type' => Number::class,
            'options' => [
                'label' => 'Login Max Password Length',
                'column-size' => 'sm-6',
                'label_attributes' => [
                    'class' => 'col-sm-6',
                ],
            ],
        ]);

        $this->add([
            'name' => 'register_min_password_length',
            'type' => Number::class,
            'options' => [
                'label' => 'Register Min Password Length',
                'column-size' => 'sm-6',
                'label_attributes' => [
                    'class' => 'col-sm-6',
                ],
            ],
        ]);

        $this->add([
            'name' => 'register_max_password_length',
            'type' => Number::class,
            'options' => [
                'label' => 'Register Max Password Length',
                'column-size' => 'sm-6',
                'label_attributes' => [
                    'class' => 'col-sm-6',
                ],
            ],
        ]);
    }

    public function getInputFilterSpecification(): array
    {
        return [
            'login_min_password_length' => [
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    ['name' => IsInt::class],
                ],
            ],
            'login_max_password_length' => [
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    ['name' => IsInt::class],
                ],
            ],
            'register_min_password_length' => [
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    ['name' => IsInt::class],
                ],
            ],
            'register_max_password_length' => [
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    ['name' => IsInt::class],
                ],
            ],
        ];
    }
}
