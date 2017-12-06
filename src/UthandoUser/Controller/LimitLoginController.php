<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 04/12/17 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoUser\Controller;

use UthandoCommon\Controller\AbstractCrudController;
use UthandoUser\Service\LimitLoginService;

class LimitLoginController extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'id'];
    protected $serviceName = LimitLoginService::class;
    protected $route = 'admin/user/limit-login';
}
