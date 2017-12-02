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
use UthandoUser\InputFilter\User as UserInputFilter;
use Zend\Form\Element\Submit;
use Zend\InputFilter\InputFilterInterface;

/**
 * Class Register
 *
 * @package UthandoUser\Form
 */
class Register extends BaseUser
{
    public function init(): void
    {
        parent::init();

        $this->remove('userId')
            ->remove('role')
            ->remove('dateCreated')
            ->remove('dateModified')
            ->remove('active');

        $this->add([
            'name' => 'submit',
            'type' => Submit::class,
            'options' => [
                'label' => 'Register',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ],
        ], ['priority' => -1000]);
    }
}
