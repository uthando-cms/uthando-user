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

use UthandoUser\Option\UserOptions;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class UserFieldSet
 *
 * @package UthandoUser\Form\Settings
 */
class UserFieldSet extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setHydrator(new ClassMethods())
            ->setObject(new UserOptions());
    }

    public function init()
    {
        $this->add([
            'name' => 'loginMinPasswordLength',
            'type' => 'number',
            'options' => [
                'label' => 'Login Min Password Length',
                'column-size' => 'md-6',
                'label_attributes' => [
                    'class' => 'col-md-6',
                ],
            ],
        ]);

        $this->add([
            'name' => 'loginMaxPasswordLength',
            'type' => 'number',
            'options' => [
                'label' => 'Login Max Password Length',
                'column-size' => 'md-6',
                'label_attributes' => [
                    'class' => 'col-md-6',
                ],
            ],
        ]);

        $this->add([
            'name' => 'registerMinPasswordLength',
            'type' => 'number',
            'options' => [
                'label' => 'Register Min Password Length',
                'column-size' => 'md-6',
                'label_attributes' => [
                    'class' => 'col-md-6',
                ],
            ],
        ]);

        $this->add([
            'name' => 'registerMaxPasswordLength',
            'type' => 'number',
            'options' => [
                'label' => 'Register Max Password Length',
                'column-size' => 'md-6',
                'label_attributes' => [
                    'class' => 'col-md-6',
                ],
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'loginMinPasswordLength' => [
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    ['name' => 'Int'],
                ],
            ],
            'loginMaxPasswordLength' => [
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    ['name' => 'Int'],
                ],
            ],
            'registerMinPasswordLength' => [
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    ['name' => 'Int'],
                ],
            ],
            'registerMaxPasswordLength' => [
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    ['name' => 'Int'],
                ],
            ],
        ];
    }
}
