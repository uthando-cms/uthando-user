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

use UthandoUser\Form\Settings\AuthFieldSet;
use UthandoUserTest\Framework\TestCase;

class AuthFieldSetTest extends TestCase
{
    public function testCanCreateFormServiceManager()
    {
        /* @var $form \UthandoUser\Form\UserSettings */
        $form = $this->serviceManager->get('FormElementManager')
            ->get('UthandoUserAuthFieldSet');

        $this->assertInstanceOf('UthandoUser\Form\Settings\AuthFieldSet', $form);
    }

    public function testInit()
    {
        $form = new AuthFieldSet();

        $form->getFormFactory()->setFormElementManager($this->serviceManager->get('FormElementManager'));
        $form->init();

        // check form elements are created
        $this->assertTrue($form->has('authenticateMethod'));
        $this->assertTrue($form->has('credentialTreatment'));
        $this->assertTrue($form->has('useFallbackTreatment'));
        $this->assertTrue($form->has('fallbackCredentialTreatment'));
    }

    public function testGetInputFilterSpecification()
    {
        $form = new AuthFieldSet();

        $formSpec = $form->getInputFilterSpecification();

        $this->assertInternalType('array', $formSpec);
        $this->assertEquals(4, count($formSpec));
    }
}
