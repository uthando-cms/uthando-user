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

/**
 * Class User
 * @package UthandoUser\Service
 */
class User extends AbstractMapperService
{   
	protected $serviceAlias = 'UthandoUser';

    /**
     * @param $email
     * @param null $ignore
     * @param bool $emptyPassword
     * @return mixed
     */
    public function getUserByEmail($email, $ignore=null, $emptyPassword = true)
    {
    	$email = (string) $email;
        /* @var $mapper \UthandoUser\Mapper\User */
        $mapper = $this->getMapper();
    	return $mapper->getUserByEmail($email, $ignore, $emptyPassword);
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
    	
    	$form->setValidationGroup('firstname', 'lastname', 'email', 'userId');
		
		$saved = parent::edit($model, $post, $form);
		
		if (!$saved instanceof Form && $saved) {
		    $this->getEventManager()->trigger('user.edit', $this, $post);
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
    
    public function resetPassword()
    {
        
    }

    /**
     * @param array|ModelInterface $data
     * @return int
     * @deprecated moving to event listener
     */
    public function save($data)
    {	
        if ($data instanceof UserModel) {
            $data = $this->getMapper()->extract($data);
        }

    	if (array_key_exists('passwd', $data) && '' != $data['passwd']) {
    		$data['passwd'] = $this->createPassword($data['passwd']);
    	} else {
    		unset($data['passwd']);
    	}
    
 		return parent::save($data);
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
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
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
