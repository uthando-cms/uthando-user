<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */
namespace UthandoUser\Controller;

use UthandoCommon\Controller\AbstractCrudController;

/**
 * Class AdminController
 * @package UthandoUser\Controller
 */
class AdminController extends AbstractCrudController
{
    protected $searchDefaultParams = ['sort' => 'lastname'];
    protected $serviceName = 'UthandoUser';
    protected $route = 'admin/user';
    
}
