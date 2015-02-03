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

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Form;
use Zend\View\Model\ViewModel;

/**
 * Class UserController
 * @package UthandoUser\Controller
 * @method \Zend\Session\Container sessionContainer()
 */
class UserController extends AbstractActionController
{
	/**
	 * @var \UthandoUser\Service\User
	 */
	protected $userService;
	
	public function thankYouAction()
	{
	    $container = $this->sessionContainer(get_class($this));
	    $email = $container->offsetGet('email');
	    $returnTo = $container->offsetGet('returnTo');
	    $user = $this->getUserService()->getUserByEmail($email);
	    
	    $emailView = new ViewModel([
	        'user' => $user,
	    ]);
	    $emailView->setTemplate('uthando-user/email/verify');
	    
	    $this->getEventManager()->trigger('mail.send', $this, [
            'recipient'        => [
                'name'      => $user->getFullName(),
                'address'   => $user->getEmail(),
            ],
            'layout'           => 'uthando-user/email/layout',
	        'body'             => $emailView,
            'subject'          => 'Verify Account',
            'transport'        => 'default',
        ]);
	    
		return [
		    'user'        => $user,
		    'returnTo'    => $returnTo,
		];
	}
	
	public function registerAction()
	{
        $request = $this->getRequest();
        
        if ($request->isPost()) {
        	
        	$post = $this->params()->fromPost();
        	$post['role'] = 'registered'; 
        
        	$result = $this->getUserService()->add($post);
        
        	if ($result instanceof Form) {
        		$this->flashMessenger()->addInfoMessage(
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
                        
                    $user = $this->getUserService()->getById($result);
                    $emailView = new ViewModel([
                        'user' => $user,
                    ]);
                    $emailView->setTemplate('uthando-user/email/register');
                        
                    $this->getEventManager()->trigger('mail.send', $this, [
                        'recipient'        => [
                            'name'      => $user->getFullName(),
                            'address'   => $user->getEmail(),
                        ],
                        'layout'           => 'uthando-user/email/layout',
                        'body'             => $emailView,
                        'subject'          => 'Verify Account',
                        'transport'        => 'default',
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
        
        return new ViewModel(array(
        	'registerForm' => $this->getUserService()->getForm(),
        ));
	}
	
	public function activeAccountAction()
	{
	    
	}

	public function forgotPasswordAction()
	{

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
	    
	    return [
	        'form' => $this->getUserService()->getForm(),
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
                $result = $this->getUserService()->edit($user, $params);
            } else {
                // Redirect to user
                return $this->redirect()->toRoute('user');
            }
				
			if ($result instanceof Form) {

				$this->flashMessenger()->addInfoMessage(
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
		
		$form = $this->getUserService()->getForm($user);
		
		return new ViewModel([
			'form' => $form
		]);
	}
	
	public function loginAction()
	{
		return [
			//'loginForm' => $this->getUserService()->getForm()
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
		/* @var $form \UthandoUser\Form\Login */
		$form = $this->getServiceLocator()
			->get('FormElementManager')
			->get('UthandoUserLogin');

		$inputFilter = $this->getServiceLocator()
			->get('InputFilterManager')
			->get('UthandoUser');
		$form->setInputFilter($inputFilter);

		$form->setData($post);
		$form->setValidationGroup('passwd', 'email', 'rememberme');
	
		$viewModel = new ViewModel();
	
		$viewModel->setTemplate('uthando-user/user/login');
	
		if (!$form->isValid()) {
			return $viewModel->setVariables(['loginForm' => $form]); // re-render the login form
		}
	
		$data = $form->getData();

		/* @var $auth \UthandoUser\Service\Authentication */
		$auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
	
		if (false === $auth->doAuthentication($data['email'], $data['passwd'])) {
			
			$this->flashMessenger()->addErrorMessage(
				'Login failed, Please try again.'
			);
	
			return $viewModel->setVariables(['form' => $form]); // re-render the login form
		}

		if ($data['rememberme'] == 1) {
			$auth->getStorage()->rememberMe(1);
		}

        $returnTo = $this->params()->fromPost('returnTo', null);

		$return = ($returnTo) ? $returnTo : 'home';
	
		return $this->redirect()->toRoute($return);
	}
	
	/**
	 * @return \UthandoUser\Service\User
	 */
	protected function getUserService()
	{
		if (!$this->userService) {
			$sl = $this->getServiceLocator();
			$this->userService = $sl->get('UthandoUser\Service\User');
		}
		
		return $this->userService;
	}
}

