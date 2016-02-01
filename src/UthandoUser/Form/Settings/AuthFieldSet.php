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

use UthandoUser\Options\AuthOptions;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

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

    public function init()
    {
        $this->add([
            'name' => 'authenticateMethod',
            'type' => 'text',
            'options' => [
                'label' => 'Authenticate Method',
                'column-size' => 'sm-6',
                'label_attributes' => [
                    'class' => 'col-sm-6',
                ],
            ],
        ]);

        $this->add([
            'name' => 'credentialTreatment',
            'type' => 'text',
            'options' => [
                'label' => 'Credential Treatment',
                'column-size' => 'sm-6',
                'label_attributes' => [
                    'class' => 'col-sm-6',
                ],
            ],
        ]);

        $this->add([
            'name' => 'useFallbackTreatment',
            'type' => 'checkbox',
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
            'name' => 'fallbackCredentialTreatment',
            'type' => 'text',
            'options' => [
                'label' => 'Fallback Credential Treatment',
                'column-size' => 'sm-6',
                'label_attributes' => [
                    'class' => 'col-sm-6',
                ],
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'authenticateMethod' => [
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
            ],
            'credentialTreatment' => [
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
            ],
            'useFallbackTreatment' => [
                'required' => false,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
            ],
            'fallbackCredentialTreatment' => [
                'required' => false,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
            ],
        ];
    }
}
