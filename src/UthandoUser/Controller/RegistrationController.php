<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Controller;

use UthandoUser\Service\UserRegistration;
use Zend\Mvc\Controller\AbstractActionController;
use UthandoCommon\Service\ServiceTrait;

/**
 * Class RegistrationController
 * @package UthandoUser\Controller
 * @method \Zend\Session\Container sessionContainer()
 * @method \Zend\Http\Request getRequest()
 */
class RegistrationController extends AbstractActionController
{
    use ServiceTrait;

    public function __construct()
    {
        $this->serviceName = UserRegistration::class;
    }

    public function verifyEmailAction()
    {
        if (!$this->getRequest()->isGet()) {
            return $this->redirect()->toRoute('home');
        }

        $token = $this->params('token', null);
        $email = $this->params('email', null);

        $result = false;

        if ($token && $email) {
            $result = $this->getService()->verify($token, $email);
        }

        return [
            'result' => $result,
        ];
    }
}
