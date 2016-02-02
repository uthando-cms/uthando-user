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

use UthandoUser\Form\Login;
use UthandoUserTest\Framework\TestCase;

class LoginTest extends TestCase
{
    public function testCanCreateFormServiceManager()
    {
        $form = $this->serviceManager
            ->get('FormElementManager')
            ->get('UthandoUserLogin');

        $this->assertInstanceOf('UthandoUser\Form\Login', $form);
    }

    public function testInit()
    {
        $form = new Login();

        $form->getFormFactory()->setFormElementManager($this->serviceManager->get('FormElementManager'));
        $form->init();

        $this->assertFalse($form->has('active'));
        $this->assertFalse($form->has('firstname'));
        $this->assertFalse($form->has('lastname'));
        $this->assertTrue($form->has('email'));
        $this->assertTrue($form->has('show-password'));
        $this->assertTrue($form->has('passwd'));
        $this->assertFalse($form->has('passwd-confirm'));
        $this->assertFalse($form->has('dateCreated'));
        $this->assertFalse($form->has('dateModified'));
        $this->assertFalse($form->has('userId'));
        $this->assertTrue($form->has('security'));
        $this->assertTrue($form->has('returnTo'));
        $this->assertFalse($form->has('captcha'));
        $this->assertTrue($form->has('submit'));
    }
}
