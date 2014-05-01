<?php

namespace UthandoUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use UthandoUser\Form\Password as PasswordForm;
use UthandoUser\Form\User as UserForm;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{
	/**
	 * @var \UthandoUser\Service\User
	 */
	protected $userService;
	
	public function thankYouAction()
	{
		return new ViewModel();
	}
	
	public function registerAction()
	{
        $request = $this->getRequest();
        
        if ($request->isPost()) {
        	
        	$post = $this->params()->fromPost();
        	$post['role'] = 'registered'; 
        
        	$result = $this->getUserService()->add($post);
        
        	if ($result instanceof UserForm) {
        		$this->flashMessenger()->addInfoMessage(
        			'There were one or more isues with your submission. Please correct them as indicated below.'
        		);
        
        		return new ViewModel([
        			'form' => $result
        		]);
        
        	} else {
        		if ($result) {
        			$this->flashMessenger()->addSuccessMessage(
        				'Thank you, you have successfully registered with us.'
        			);
        			
        			// log user in
        			$this->getServiceLocator()
        			     ->get('Zend\Authentication\AuthenticationService')
        			     ->doAuthentication($post);
        			
        			$return = ($post['returnTo']) ? $post['returnTo'] : 'user/thank-you';
        			
        			return $this->redirect()->toRoute($return);
        			
        		} else {
        			$this->flashMessenger()->addErrorMessage(
        				'We could not register you due to a database error. Please try again later.'
        			);
        		}
        	}
        }
        
        return new ViewModel(array(
        	'form' => $this->getUserService()->getForm(),
        ));
	}
	
	public function passwordAction()
	{
	    $request = $this->getRequest();
	    /* @var $user \UthandoUser\Model\User */
	    $user = $this->identity();
	    
	    if ($request->isPost()) {
	        $params = $this->params()->fromPost();
	        
	        $result = $this->getUserService()->changePasswd($params, $user);
	        
	        if ($result instanceof PasswordForm) {
	            $this->flashMessenger()->addInfoMessage(
	               'There were one or more isues with your submission. Please correct them as indicated below.'
                );
	            
	            return [
	                'form' => $result,
	            ];
	        }
	        
	        // Redirect to user
            return $this->redirect()->toRoute('user');
	    }
	    
	    return [
	        'form' => $this->getServiceLocator()->get('UthandoUser\Form\Password'),
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
				
			if ($result instanceof UserForm) {

				$this->flashMessenger()->addInfoMessage(
					'There were one or more isues with your submission. Please correct them as indicated below.'
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
						'We could not save your cahnges due to a database error.'
					);
				}
			}
		}
		
		$form = $this->getUserService()->getForm($user);
		
		return new ViewModel([
			'form' => $form
		]);
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

