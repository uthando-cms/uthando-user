<?php

namespace UthandoUser\Service\Factory;

use UthandoUser\Controller\AuthController;
use UthandoUser\Form\Login as LoginForm;
use UthandoUser\InputFilter\Login as LoginFilter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        $serviceLocator = $services->getServiceLocator();
        $auth           = $serviceLocator->get('Zend\Authentication\AuthenticationService');
        
        $filter  = new LoginFilter();
        $form    = new LoginForm();
        $form->setInputFilter($filter);

        $controller = new AuthController();
        $controller->setLoginForm($form);
        $controller->setAuthService($auth);
        
        return $controller;
    }
}
