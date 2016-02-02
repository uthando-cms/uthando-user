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

use UthandoUser\Form\BaseUser;
use UthandoUserTest\Framework\TestCase;

class BaseUserTest extends TestCase
{
    public function testCanCreateForm()
    {
        $form = new BaseUser();

        $this->assertInstanceOf('UthandoUser\Form\BaseUser', $form);
    }

    public function testInit()
    {
        $form = new BaseUser();

        $form->getFormFactory()->setFormElementManager($this->serviceManager->get('FormElementManager'));
        $form->init();

        $this->assertTrue($form->has('active'));
        $this->assertTrue($form->has('firstname'));
        $this->assertTrue($form->has('lastname'));
        $this->assertTrue($form->has('email'));
        $this->assertTrue($form->has('show-password'));
        $this->assertTrue($form->has('passwd'));
        $this->assertTrue($form->has('passwd-confirm'));
        $this->assertTrue($form->has('dateCreated'));
        $this->assertTrue($form->has('dateModified'));
        $this->assertTrue($form->has('userId'));
        $this->assertTrue($form->has('security'));
        $this->assertTrue($form->has('returnTo'));
    }

    public function testAddCaptcha()
    {
        $form = new BaseUser();

        $form->getFormFactory()->setFormElementManager($this->serviceManager->get('FormElementManager'));
        $form->addCaptcha();

        $this->assertTrue($form->has('captcha'));
    }
}
