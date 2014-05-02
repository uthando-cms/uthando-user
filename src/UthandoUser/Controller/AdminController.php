<?php

namespace UthandoUser\Controller;

use UthandoCommon\Controller\AbstractCrudController;

class AdminController extends AbstractCrudController
{
    protected $searchDefaultParams = ['sort' => 'lastname'];
    protected $serviceName = 'UthandoUser\Service\User';
    protected $route = 'admin/user';
    
}
