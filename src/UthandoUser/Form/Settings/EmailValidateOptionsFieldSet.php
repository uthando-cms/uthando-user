<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Form\Settings
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);


namespace UthandoUser\Form\Settings;


use Zend\Filter\Boolean;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Select;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\Hostname;

class EmailValidateOptionsFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function init()
    {
        $this->add([
            'name' => 'allow',
            'type' => Select::class,
            'options' => [
                'label' => 'Email Validation',
                'column-size' => 'sm-6',
                'label_attributes' => [
                    'class' => 'col-sm-6',
                ],
                'value_options' => [
                    Hostname::ALLOW_DNS     => 'Allows Internet domain names (e.g., example.com)',
                    Hostname::ALLOW_IP      => 'Allows IP addresses',
                    Hostname::ALLOW_LOCAL   => 'Allows local network names (e.g., localhost, www.localdomain)',
                    Hostname::ALLOW_URI     => 'Allows URI hostnames',
                    Hostname::ALLOW_ALL     => 'Allows all types of hostnames',
                ],
            ],
        ]);

        $this->add([
            'name' => 'useMxCheck',
            'type' => Checkbox::class,
            'options' => [
                'label' => 'Use MX Check',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' => false,
                'column-size' => 'sm-6 col-sm-offset-6',
            ],
        ]);

        $this->add([
            'name' => 'useDeepMxCheck',
            'type' => Checkbox::class,
            'options' => [
                'label' => 'Use Deep MX Check',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' => false,
                'column-size' => 'sm-6 col-sm-offset-6',
            ],
        ]);

        $this->add([
            'name' => 'useDomainCheck',
            'type' => Checkbox::class,
            'options' => [
                'label' => 'Use Domain Check',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' => false,
                'column-size' => 'sm-6 col-sm-offset-6',
            ],
        ]);

        $this->add([
            'name' => 'strict',
            'type' => Checkbox::class,
            'options' => [
                'label' => 'Strict',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' => false,
                'column-size' => 'sm-6 col-sm-offset-6',
            ],
        ]);
    }

    public function getInputFilterSpecification(): array
    {
        return [
            'useMxCheck' => [
                'required' => true,
                'allow_empty' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Boolean::class, 'options' => [
                        'type' => Boolean::TYPE_ZERO_STRING,
                    ]],
                ],
            ],
            'useDeepMxCheck' => [
                'required' => true,
                'allow_empty' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Boolean::class, 'options' => [
                        'type' => Boolean::TYPE_ZERO_STRING,
                    ]],
                ],
            ],
            'useDomainCheck' => [
                'required' => true,
                'allow_empty' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Boolean::class, 'options' => [
                        'type' => Boolean::TYPE_ZERO_STRING,
                    ]],
                ],
            ],
            'strict' => [
                'required' => true,
                'allow_empty' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Boolean::class, 'options' => [
                        'type' => Boolean::TYPE_ZERO_STRING,
                    ]],
                ],
            ],
            'allow' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => ToInt::class],
                ],
            ],
        ];
    }
}