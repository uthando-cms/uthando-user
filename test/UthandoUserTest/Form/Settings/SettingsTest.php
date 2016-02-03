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

use UthandoUser\Form\Settings\Settings;
use UthandoUserTest\Framework\TestCase;

class SettingsTest extends TestCase
{
    public function testCanCreateFormServiceManager()
    {
        /* @var $form \UthandoUser\Form\UserSettings */
        $form = $this->serviceManager->get('FormElementManager')
            ->get('UthandoUserSettings');

        $this->assertInstanceOf('UthandoUser\Form\Settings\Settings', $form);
    }

    public function testInit()
    {
        $form = new Settings();

        $form->getFormFactory()->setFormElementManager($this->serviceManager->get('FormElementManager'));
        $form->init();

        // check form elements are created
        $this->assertInstanceOf('UthandoUser\Form\Settings\UserFieldSet', $form->get('user_options'));
        $this->assertInstanceOf('UthandoUser\Form\Settings\AuthFieldSet', $form->get('auth'));
    }
}
