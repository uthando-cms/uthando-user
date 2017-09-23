<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Controller;

use UthandoCommon\Controller\AbstractCrudController;

/**
 * Class AdminRegistrationController
 *
 * @package UthandoUser\Controller
 */
class AdminRegistrationController extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'requestTime'];
    protected $serviceName = 'UthandoUserRegistration';
    protected $route = 'admin/user/register';
}
