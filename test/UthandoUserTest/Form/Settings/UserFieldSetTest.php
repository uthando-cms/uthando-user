<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUserTest\Form\Settings
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUserTest\Form\Settings;

use UthandoUser\Form\Settings\UserFieldSet;
use UthandoUserTest\Framework\TestCase;

class UserFieldSetTest extends TestCase
{
    public function testCanCreateFormServiceManager()
    {
        /* @var $form \UthandoUser\Form\UserSettings */
        $form = $this->serviceManager->get('FormElementManager')
            ->get('UthandoUserFieldSet');

        $this->assertInstanceOf('UthandoUser\Form\Settings\UserFieldSet', $form);
    }

    public function testInit()
    {
        $form = new UserFieldSet();

        $form->getFormFactory()->setFormElementManager($this->serviceManager->get('FormElementManager'));
        $form->init();

        // check form elements are created
        $this->assertTrue($form->has('loginMinPasswordLength'));
        $this->assertTrue($form->has('loginMaxPasswordLength'));
        $this->assertTrue($form->has('registerMinPasswordLength'));
        $this->assertTrue($form->has('registerMaxPasswordLength'));
    }

    public function testGetInputFilterSpecification()
    {
        $form = new UserFieldSet();

        $formSpec = $form->getInputFilterSpecification();

        $this->assertInternalType('array', $formSpec);
        $this->assertEquals(4, count($formSpec));
    }
}

