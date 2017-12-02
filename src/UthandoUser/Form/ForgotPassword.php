<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Form
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Element\Submit;

/**
 * Class ForgotPassword
 *
 * @package UthandoUser\Form
 */
class ForgotPassword extends BaseUser
{
    public function init(): void
    {
        parent::init();

        $this->remove('userId')
            ->remove('firstname')
            ->remove('lastname')
            ->remove('show-password')
            ->remove('passwd')
            ->remove('passwd-confirm')
            ->remove('role')
            ->remove('dateCreated')
            ->remove('dateModified')
            ->remove('active');

        $this->addCaptcha();

        $this->add([
            'name' => 'submit',
            'type' => Submit::class,
            'options' => [
                'label' => 'Reset Password',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ]
        ]);

    }
}
