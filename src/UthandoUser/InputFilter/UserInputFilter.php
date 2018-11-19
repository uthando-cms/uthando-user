<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\InputFilter
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\InputFilter;

use UthandoCommon\Filter\Ucwords;
use UthandoUser\Options\LoginOptions;
use Zend\Db\Adapter\Adapter;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterPluginManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\Validator\Db\NoRecordExists;
use Zend\Validator\Db\RecordExists;
use Zend\Validator\EmailAddress;
use Zend\Validator\Hostname;
use Zend\Validator\Identical;
use Zend\Validator\StringLength;

/**
 * Class User
 *
 * @package UthandoUser\InputFilter
 * @method InputFilterPluginManager getServiceLocator()
 */
class UserInputFilter extends InputFilter implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function init(): void
    {
        $this->add([
            'name' => 'userId',
            'required' => false,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => ToInt::class],
            ],
        ]);

        $this->add([
            'name' => 'firstname',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => Ucwords::class],
            ],
            'validators' => [
                ['name' => StringLength::class, 'options' => [
                    'encoding' => 'UTF-8',
                    'min' => 2,
                    'max' => 255,
                ]],
            ],
        ]);

        $this->add([
            'name' => 'lastname',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => Ucwords::class],
            ],
            'validators' => [
                ['name' => 'StringLength', 'options' => [
                    'encoding' => 'UTF-8',
                    'min' => 2,
                    'max' => 255,
                ]],
            ],
        ]);

        $this->add([
            'name' => 'passwd',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
        ]);

        $this->add([
            'name' => 'passwd-confirm',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => Identical::class, 'options' => [
                    'token' => 'passwd',
                ]],
            ],
        ]);

        $this->add([
            'name' => 'email',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                ['name' => EmailAddress::class, 'options' => [
                    'allow' => Hostname::ALLOW_DNS,
                    'useMxCheck' => true,
                    'useDeepMxCheck' => true
                ]],
            ],
        ]);

        $this->add([
            'name' => 'role',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
        ]);
    }

    public function addPasswordLength(string $type): UserInputFilter
    {
        $type = ucfirst($type);

        $options = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(LoginOptions::class);

        $minMethod = 'get' . $type . 'MinPasswordLength';
        $maxMethod = 'get' . $type . 'MaxPasswordLength';

        $this->get('passwd')
            ->getValidatorChain()
            ->attachByName(StringLength::class, [
                'min' => $options->$minMethod(),
                'max' => $options->$maxMethod(),
                'encoding' => 'UTF-8',
            ]);

        return $this;
    }

    public function addEmailNoRecordExists(?string $exclude): UserInputFilter
    {
        $exclude = (!$exclude) ?: [
            'field' => 'email',
            'value' => $exclude,
        ];

        $this->get('email')
            ->getValidatorChain()
            ->attachByName(NoRecordExists::class, [
                'table' => 'user',
                'field' => 'email',
                'adapter' => $this->getServiceLocator()->getServiceLocator()->get(Adapter::class),
                'exclude' => $exclude,
            ]);

        return $this;
    }

    public function addEmailRecordExists(?string $exclude): UserInputFilter
    {
        $exclude = (!$exclude) ?: [
            'field' => 'email',
            'value' => $exclude,
        ];

        $this->get('email')
            ->getValidatorChain()
            ->attachByName(RecordExists::class, [
                'table' => 'user',
                'field' => 'email',
                'adapter' => $this->getServiceLocator()->getServiceLocator()->get(Adapter::class),
                'exclude' => $exclude,
            ]);

        return $this;
    }
}
