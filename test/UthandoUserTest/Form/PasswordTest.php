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

use UthandoUser\Form\Password;
use UthandoUserTest\Framework\TestCase;

class PasswordTest extends TestCase
{
    public function testCanCreateFormServiceManager()
    {
        $form = $this->serviceManager
            ->get('FormElementManager')
            ->get('UthandoUserPassword');

        $this->assertInstanceOf('UthandoUser\Form\Password', $form);
    }

    public function testInit()
    {
        $form = new Password();

        $form->getFormFactory()->setFormElementManager($this->serviceManager->get('FormElementManager'));
        $form->init();

        $this->assertFalse($form->has('active'));
        $this->assertFalse($form->has('firstname'));
        $this->assertFalse($form->has('lastname'));
        $this->assertFalse($form->has('email'));
        $this->assertTrue($form->has('show-password'));
        $this->assertTrue($form->has('passwd'));
        $this->assertTrue($form->has('passwd-confirm'));
        $this->assertFalse($form->has('dateCreated'));
        $this->assertFalse($form->has('dateModified'));
        $this->assertFalse($form->has('userId'));
        $this->assertTrue($form->has('security'));
        $this->assertTrue($form->has('returnTo'));
        $this->assertFalse($form->has('captcha'));
        $this->assertTrue($form->has('submit'));
    }
}
