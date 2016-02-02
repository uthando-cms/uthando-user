<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUserTest\Form
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUserTest\Form;

use UthandoUser\Form\ForgotPassword;
use UthandoUserTest\Framework\TestCase;

class ForgotPasswordTest extends TestCase
{
    public function testCanCreateFormServiceManager()
    {
        $form = $form = $this->serviceManager
            ->get('FormElementManager')
            ->get('UthandoUserforgotPassword');

        $this->assertInstanceOf('UthandoUser\Form\ForgotPassword', $form);
    }

    public function testInit()
    {
        $form = new ForgotPassword();

        $form->getFormFactory()->setFormElementManager($this->serviceManager->get('FormElementManager'));
        $form->init();

        $this->assertFalse($form->has('active'));
        $this->assertFalse($form->has('firstname'));
        $this->assertFalse($form->has('lastname'));
        $this->assertTrue($form->has('email'));
        $this->assertFalse($form->has('show-password'));
        $this->assertFalse($form->has('passwd'));
        $this->assertFalse($form->has('passwd-confirm'));
        $this->assertFalse($form->has('dateCreated'));
        $this->assertFalse($form->has('dateModified'));
        $this->assertFalse($form->has('userId'));
        $this->assertTrue($form->has('security'));
        $this->assertTrue($form->has('returnTo'));
        $this->assertTrue($form->has('captcha'));
        $this->assertTrue($form->has('submit'));
    }
}
