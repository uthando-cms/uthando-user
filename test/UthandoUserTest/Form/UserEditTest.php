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

use UthandoUser\Form\UserFormEdit;
use UthandoUserTest\Framework\TestCase;

class UserEditTest extends TestCase
{
    public function testCanCreateFormServiceManager()
    {
        $form = $this->serviceManager
            ->get('FormElementManager')
            ->get('UthandoUserEdit');

        $this->assertInstanceOf('UthandoUser\Form\UserFormEdit', $form);
    }

    public function testInit()
    {
        $form = new UserFormEdit();

        $form->getFormFactory()->setFormElementManager($this->serviceManager->get('FormElementManager'));
        $form->init();

        $this->assertFalse($form->has('active'));
        $this->assertTrue($form->has('firstname'));
        $this->assertTrue($form->has('lastname'));
        $this->assertTrue($form->has('email'));
        $this->assertFalse($form->has('show-password'));
        $this->assertFalse($form->has('passwd'));
        $this->assertFalse($form->has('passwd-confirm'));
        $this->assertFalse($form->has('dateCreated'));
        $this->assertFalse($form->has('dateModified'));
        $this->assertTrue($form->has('userId'));
        $this->assertTrue($form->has('security'));
        $this->assertTrue($form->has('returnTo'));
        $this->assertFalse($form->has('captcha'));
        $this->assertTrue($form->has('submit'));
    }
}
