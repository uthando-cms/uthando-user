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

use UthandoUser\Form\User;
use UthandoUserTest\Framework\TestCase;

class UserTest extends TestCase
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
        $form = new User();

        $form->getFormFactory()->setFormElementManager($this->serviceManager->get('FormElementManager'));
        $form->init();

        $this->assertTrue($form->has('active'));
        $this->assertTrue($form->has('firstname'));
        $this->assertTrue($form->has('lastname'));
        $this->assertTrue($form->has('email'));
        $this->assertFalse($form->has('show-password'));
        $this->assertFalse($form->has('passwd'));
        $this->assertFalse($form->has('passwd-confirm'));
        $this->assertTrue($form->has('dateCreated'));
        $this->assertTrue($form->has('dateModified'));
        $this->assertTrue($form->has('userId'));
        $this->assertTrue($form->has('security'));
        $this->assertTrue($form->has('returnTo'));
        $this->assertFalse($form->has('captcha'));
        $this->assertFalse($form->has('submit'));
    }

    public function testIncludePasswordOption()
    {
        $form = new User(null, [
            'include_password' => true,
        ]);

        $form->getFormFactory()->setFormElementManager($this->serviceManager->get('FormElementManager'));
        $form->init();

        $this->assertTrue($form->has('show-password'));
        $this->assertTrue($form->has('passwd'));
        $this->assertTrue($form->has('passwd-confirm'));
    }
}
