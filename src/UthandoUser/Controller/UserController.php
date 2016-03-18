<?php
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

use UthandoUser\Model\User;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Form;
use Zend\View\Model\ViewModel;
use UthandoCommon\Service\ServiceTrait;

/**
 * Class UserController
 * @package UthandoUser\Controller
 * @method \Zend\Session\Container sessionContainer()
 */
class UserController extends AbstractActionController
{
    use ServiceTrait;

    /**
     * @var \UthandoUser\Service\User
     */
    protected $userService;

    public function __construct()
    {
        $this->serviceName = 'UthandoUser';
    }

    public function thankYouAction()
    {
        $container = $this->sessionContainer(get_class($this));

        $email = $container->offsetGet('email');

        if (null === $email) {
            return $this->redirect()->toRoute('user', [
                'action' => 'login',
            ]);
        }

        /* @var $service \UthandoUser\Service\UserRegistration */
        $service = $this->getService('UthandoUserRegistration');
        $service->sendVerificationEmail($email);

        return [];
    }

    public function registerAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {

            $post = $this->params()->fromPost();
            $post['role'] = 'registered';

            $result = $this->getUserService()->register($post);

            if ($result instanceof Form) {
                $this->flashMessenger()->addErrorMessage(
                    'There were one or more issues with your submission. Please correct them as indicated below.'
                );

                return new ViewModel([
                    'registerForm' => $result
                ]);

            } else {
                if ($result) {
                    $this->flashMessenger()->addSuccessMessage(
                        'Thank you, you have successfully registered with us.'
                    );

                    // add return and email to session.
                    $this->sessionContainer(get_class($this))
                        ->exchangeArray([
                            'email' => $post['email'],
                            'returnTo' => $post['returnTo'],
                        ]);

                    return $this->redirect()->toRoute('user', [
                        'action' => 'thank-you',
                    ]);

                } else {
                    $this->flashMessenger()->addErrorMessage(
                        'We could not register you due to a database error. Please try again later.'
                    );
                }
            }
        }

        $form = $this->getUserService()
            ->getForm('UthandoUserRegister');

        return new ViewModel(array(
            'registerForm' => $form,
        ));
    }

    /**
     * @return \UthandoUser\Service\User
     */
    protected function getUserService()
    {
        return $this->getService();
    }

    public function forgotPasswordAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $this->params()->fromPost();

            $result = $this->getUserService()->forgotPassword($data);

            if ($result instanceof Form) {
                $this->flashMessenger()->addErrorMessage(
                    'There were one or more issues with your submission. Please correct them as indicated below.'
                );

                return [
                    'form' => $result,
                ];
            } else {
                if ($result) {
                    $this->flashMessenger()->addSuccessMessage(
                        'Your new password has been saved and will be emailed to you.'
                    );

                    return $this->redirect()->toRoute('user');
                } else {
                    $this->flashMessenger()->addErrorMessage(
                        'We could not change password due to database error.'
                    );
                }
            }
        }

        $form = $this->getUserService()->getForm('UthandoUserForgotPassword');

        return [
            'form' => $form,
        ];
    }

    public function passwordAction()
    {
        $request = $this->getRequest();
        /* @var $user \UthandoUser\Model\User */
        $user = $this->identity();

        if ($request->isPost()) {
            $params = $this->params()->fromPost();

            $result = $this->getUserService()->changePassword($params, $user);

            if ($result instanceof Form) {
                $this->flashMessenger()->addErrorMessage(
                    'There were one or more issues with your submission. Please correct them as indicated below.'
                );

                return [
                    'form' => $result,
                ];
            }

            $this->flashMessenger()->addSuccessMessage(
                'Your new password has been saved.'
            );
        }

        $form = $this->getUserService()->getForm('UthandoUserPassword');

        return [
            'form' => $form,
        ];
    }

    public function editAction()
    {
        /* @var $user \UthandoUser\Model\User */
        $user = $this->identity();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $params = $this->params()->fromPost();

            if ($params['userId'] === $user->getUserId()) {
                $result = $this->getUserService()->editUser($user, $params);
            } else {
                // Redirect to user
                return $this->redirect()->toRoute('user');
            }

            if ($result instanceof Form) {

                $this->flashMessenger()->addErrorMessage(
                    'There were one or more issues with your submission. Please correct them as indicated below.'
                );

                return new ViewModel([
                    'form' => $result,
                    'user' => $user,
                ]);
            } else {
                if ($result) {
                    $this->flashMessenger()->addSuccessMessage(
                        'Your changes have been saved.'
                    );

                    // Redirect to user
                    return $this->redirect()->toRoute('user');

                } else {
                    $this->flashMessenger()->addErrorMessage(
                        'We could not save your changes due to a database error.'
                    );
                }
            }
        }

        /* @var \UthandoUser\Form\BaseUserEdit $form */
        $form = $this->getUserService()->getForm('UthandoUserEdit');
        $form->bind($user);

        return new ViewModel([
            'form' => $form
        ]);
    }

    public function loginAction()
    {
        $form = $this->getService('FormElementManager')
            ->get('UthandoUserLogin');

        return [
            'loginForm' => $form
        ];
    }

    public function logoutAction()
    {
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');

        $auth->clear();
        return $this->redirect()->toRoute('home');
    }

    public function authenticateAction()
    {
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return $this->redirect()->toRoute('user', [
                'action' => 'login',
            ]);
        }

        // Validate
        $post = $this->params()->fromPost();

        //if remember me is not in post then set it to zero.
        if (!isset($post['rememberme'])) {
            $post['rememberme'] = 0;
        }

        /* @var $form \UthandoUser\Form\Login */
        $form = $this->getUserService()->getForm('UthandoUserLogin');

        /* @var $inputFilter \UthandoUser\InputFilter\User */
        $inputFilter = $this->getService('InputFilterManager')
            ->get('UthandoUser');
        $inputFilter->addPasswordLength('login');

        $form->setInputFilter($inputFilter);
        $form->setValidationGroup(['email', 'passwd', 'rememberme']);

        $form->setData($post);

        $viewModel = new ViewModel();

        $viewModel->setTemplate('uthando-user/user/login');

        if (!$form->isValid()) {
            $this->flashMessenger()->addErrorMessage(
                'There were one or more issues with your submission. Please correct them as indicated below.'
            );

            return $viewModel->setVariables(['loginForm' => $form]); // re-render the login form
        }

        $data = $form->getData();

        /* @var $auth \UthandoUser\Service\Authentication */
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');

        if (false === $auth->doAuthentication($data['email'], $data['passwd'])) {

            // check if user has regisitered but not activated their account
            $user = $this->getUserService()->getUserByEmail($data['email'], null, true, false);
            if ($user instanceof User && false === $user->getActive()) {
                $this->flashMessenger()->addErrorMessage(
                    'You have not activated you account.'
                );
            } else {
                $this->flashMessenger()->addErrorMessage(
                    'Login failed, Please try again.'
                );
            }

            return $viewModel->setVariables(['loginForm' => $form]); // re-render the login form
        }

        $this->flashMessenger()->addSuccessMessage(
            'You have successfully logged in.'
        );

        if (isset($data['rememberme']) && $data['rememberme'] == 1) {
            $auth->getStorage()->rememberMe(1);
        }

        $container = $this->sessionContainer(get_class($this));
        $returnTo = ($container->offsetGet('returnTo')) ?: $this->params()->fromPost('returnTo', null);

        // clear session varibles now we have redirected.
        $container->getManager()->getStorage()->clear(get_class($this));

        $config = $this->getServiceLocator()->get('config');

        $adminRoute = (isset($config['uthando_user']['default_admin_route'])) ?
            $this->getServiceLocator()->get('config')['uthando_user']['default_admin_route'] :
            'admin';

        $return = ($returnTo) ? $returnTo : ('admin' === $auth->getIdentity()->getRole()) ? $adminRoute : 'home';

        return $this->redirect()->toRoute($return);
    }
}

