<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Controller;

use UthandoCommon\Controller\SettingsTrait;
use UthandoUser\Form\Settings\SettingsForm as SettingsForm;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class Settings
 *
 * @package UthandoUser\Controller
 */
class SettingsController extends AbstractActionController
{
    use SettingsTrait;

    public function __construct()
    {
        $this->setFormName(SettingsForm::class)
            ->setConfigKey('uthando_user');
    }
}