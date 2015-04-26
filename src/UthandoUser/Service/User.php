<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */
namespace UthandoUser\Service;

use UthandoCommon\Service\AbstractMapperService;
use Zend\Form\Form;
use UthandoCommon\Model\ModelInterface;
use UthandoUser\UthandoUserException;
use UthandoUser\Model\User as UserModel;
use Zend\Crypt\Password\PasswordInterface;
use Zend\View\Model\ViewModel;
use Zend\EventManager\Event;

/**
 * Class User
 * @package UthandoUser\Service
 */
class User extends AbstractMapperService
{   
    /**
     * @var string
     */
	protected $serviceAlias = 'UthandoUser';
	
	/**
	 * @var bool
	 */
	protected $useCache = false;
	
	/**
	 * (non-PHPdoc)
	 * @see \UthandoCommon\Service\AbstractService::attachEvents()
	 */
	public function attachEvents()
	{
	    $this->getEventManager()->attach([
	        'post.add'
        ], [$this, 'sendEmail']);
	}

    /**
     * @param $email
     * @param null $ignore
     * @param bool $emptyPassword
     * @return UserModel|null
     */
    public function getUserByEmail($email, $ignore=null, $emptyPassword=true, $activeOnly=false)
    {
    	$email = (string) $email;
        /* @var $mapper \UthandoUser\Mapper\User */
        $mapper = $this->getMapper();
    	return $mapper->getUserByEmail($email, $ignore, $emptyPassword, $activeOnly);
    }
    
    /**
     * @param Event $e
     */
    public function sendEmail(Event $e)
    {
        $userId = $e->getParam('saved', null);
        $user = $this->getById($userId);
        
        if ($user instanceof UserModel) {
            
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
                'subject'          => 'Account Registration',
                'transport'        => 'default',
            ]);
        }
    }

    /**
     * @param array $post
     * @param Form $form
     * @return int|Form
     * @deprecated moving to event listener
     */
    public function add(array $post, Form $form = null)
    {   
        $form = $this->getForm($this->getMapper()->getModel(), $post, true, true);
        /* @var $inputFilter \UthandoUser\InputFilter\User */
        $inputFilter = $form->getInputFilter();
        $inputFilter->addEmailNoRecordExists();
        
        $form->setValidationGroup(['firstname', 'lastname', 'email', 'passwd', 'passwd-confirm']);
        
        $saved = parent::add($post, $form);
        
        if (!$saved instanceof Form && $saved) {
            $this->getEventManager()->trigger('user.add', $this, $post);
        }
        
        return $saved;
    }

    /**
     * prepare data to be updated and saved into database.
     *
     * @param \UthandoCommon\Model\ModelInterface|\UthandoUser\Model\User $model
     * @param array $post
     * @param Form $form
     * @throws \UthandoUser\UthandoUserException
     * @return int results from self::save()
     * @deprecated moving to event listener
     */
    public function edit(ModelInterface $model, array $post, Form $form = null)
    {
        if (!$model instanceof UserModel) {
            throw new UthandoUserException('$model must be an instance of UthandoUser\Model\User, ' . get_class($model) . ' given.');
        }
        
    	if (!isset($post['role'])) {
    		$post['role'] = $model->getRole();
    	}
    	
    	$model->setDateModified();
    	
    	$form  = $this->getForm($model, $post, true, true);
    	
    	// we need to find if this email has changed,
    	// if not then exclude it from validation,
    	// if changed then reevaluate it.
    	$email = ($model->getEmail() === $post['email']) ? $model->getEmail() : null;

        /* @var $inputFilter \UthandoUser\InputFilter\User */
        $inputFilter = $form->getInputFilter();
        $inputFilter->addEmailNoRecordExists($email);
    	
    	$form->setValidationGroup(['firstname', 'lastname', 'email', 'userId', 'active', 'role']);
		
		$saved = parent::edit($model, $post, $form);
		
		if (!$saved instanceof Form && $saved) {
		    $this->getEventManager()->trigger('user.edit', $this, $post);
		}
		
		// move this to the post edit event
		/* @var $auth \Zend\Authentication\AuthenticationService */
		$auth = $this->getService('Zend\Authentication\AuthenticationService');
		$identity = $auth->getIdentity();
		
		// if user has updated this details write the update model to session
		if ($saved && $model instanceof UserModel && $model->getUserId() === $identity->getUserId()) {
		    $auth->getStorage()->write($model);
		}
		
		return $saved;
    }

    /**
     * @param array $post
     * @param UserModel $user
     * @return int|Form
     */
    public function changePassword(array $post, UserModel $user)
    {
        $form  = $this->getForm($user, $post, true, true);
        
        $form->setValidationGroup('passwd', 'passwd-confirm');
        
        if (!$form->isValid()) {
            return $form;
        }
        
        return parent::edit($user, $post, $form);
    }
    
    public function forgotPassword(array $post)
    {
        $email = (isset($post['email'])) ? $post['email'] : null;
        $user = $this->getUserByEmail($email);
        $form = $this->getForm(null, $post, true);
        $form->addCaptcha();
        $form->setValidationGroup([
            'email', 'captcha', 'security'
        ]);
        
        /* @var $inputFilter \UthandoUser\InputFilter\User */
        $inputFilter = $form->getInputFilter();
        $inputFilter->addEmailRecordExists();
        
        if (!$form->isValid()) {
            return $form;
        }
        
        return $this->resetPassword($user);
    }
    
    public function resetPassword(UserModel $user)
    {   
        $user->generatePassword();
        
        $result = $this->save($user);
        
        if ($result) {
        
            $emailView = new ViewModel([
                'user' => $user,
            ]);
            
            $emailView->setTemplate('uthando-user/email/reset-password');
             
            $this->getEventManager()->trigger('mail.send', $this, [
                'recipient'        => [
                    'name'      => $user->getFullName(),
                    'address'   => $user->getEmail(),
                ],
                'layout'           => 'uthando-user/email/layout',
                'body'             => $emailView,
                'subject'          => 'Reset Password',
                'transport'        => 'default',
            ]);
        }
        
        return $result;
        
    }

    /**
     * @param array|ModelInterface $data
     * @return int
     * @throws UthandoUserException
     * @throws \UthandoCommon\Service\ServiceException
     * @deprecated moving to event listener
     */
    public function save($data)
    {
        $model = null;

        if ($data instanceof UserModel) {
            $model = $data;
            $data = $this->getMapper()->extract($data);
        }

    	if (array_key_exists('passwd', $data) && '' != $data['passwd']) {
    		$data['passwd'] = $this->createPassword($data['passwd']);
    	} else {
    		unset($data['passwd']);
    	}
    
 		$result = parent::save($data);

        return $result;
    }

    /**
     * @param int $id
     * @return int
     * @throws \UthandoUser\UthandoUserException
     * @deprecated moving to event listener
     */
    public function delete($id)
    {
        $id = (int) $id;

        /* @var $auth \Zend\Authentication\AuthenticationService */
        $auth = $this->getService('Zend\Authentication\AuthenticationService');
        $identity = $auth->getIdentity();

        // sanity check to see if we are deleting ourselves!
        if ($id == $identity->getUserId()) {
            throw new UthandoUserException('You cannot delete yourself!');
        }
        
        return parent::delete($id);
    }

    /**
     * @param $password
     * @return string
     * @throws \UthandoUser\UthandoUserException
     */
    public function createPassword($password)
    {   
        $authOptions = $this->getConfig('uthando_user');

        if (!class_exists($authOptions['auth']['credentialTreatment'])) {
            throw new UthandoUserException('Credential treatment must be an class name');
        } else {
            /* @var $crypt PasswordInterface */
            $crypt = new $authOptions['auth']['credentialTreatment'];
        }
        
        if (!$crypt instanceof PasswordInterface) {
            throw new UthandoUserException('Credential treatment must be an instance of Zend\Crypt\Password\PasswordInterface');
        }
        
        $password = $crypt->create($password);
        
        return $password;
    }
}
