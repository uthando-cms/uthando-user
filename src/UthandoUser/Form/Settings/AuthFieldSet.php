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

use UthandoUser\Options\AuthOptions;
use Zend\Filter\Boolean;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Text;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Hydrator\ClassMethods;

/**
 * Class AuthFieldSet
 *
 * @package UthandoUser\Form\Settings
 */
class AuthFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setHydrator(new ClassMethods())
            ->setObject(new AuthOptions());
    }

    public function init(): void
    {
        $this->add([
            'name' => 'authenticate_method',
            'type' => Text::class,
            'options' => [
                'label' => 'Authenticate Method',
                'column-size' => 'sm-6',
                'label_attributes' => [
                    'class' => 'col-sm-6',
                ],
            ],
        ]);

        $this->add([
            'name' => 'credential_treatment',
            'type' => Text::class,
            'options' => [
                'label' => 'Credential Treatment',
                'column-size' => 'sm-6',
                'label_attributes' => [
                    'class' => 'col-sm-6',
                ],
            ],
        ]);

        $this->add([
            'name' => 'use_fallback_treatment',
            'type' => Checkbox::class,
            'options' => [
                'label' => 'Use Fallback Treatment',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'required' => false,
                'column-size' => 'sm-6 col-sm-offset-6',
            ],
        ]);

        $this->add([
            'name' => 'fallback_credential_treatment',
            'type' => Text::class,
            'options' => [
                'label' => 'Fallback Credential Treatment',
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
            'authenticate_method' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
            'credential_treatment' => [
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
            'use_fallback_treatment' => [
                'required' => false,
                'allow_empty' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                    ['name' => Boolean::class, 'options' => [
                        'type' => Boolean::TYPE_ZERO_STRING,
                    ]],
                ],
            ],
            'fallback_credential_treatment' => [
                'required' => false,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
            ],
        ];
    }
}
