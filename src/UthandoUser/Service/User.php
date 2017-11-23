<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Service;

use UthandoUser\Model\User as UserModel;
use UthandoCommon\Service\AbstractMapperService;
use UthandoUser\UthandoUserException;
use Zend\Crypt\Password\PasswordInterface;
use Zend\EventManager\Event;
use Zend\Form\Form;
use Zend\View\Model\ViewModel;

/**
 * Class User
 *
 * @package UthandoUser\Service
 * @method UserModel getModel($model = null)
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
    //protected $useCache = false;

    /**
     * (non-PHPdoc)
     * @see \UthandoCommon\Service\AbstractService::attachEvents()
     */
    public function attachEvents()
    {
        $this->getEventManager()->attach([
            'post.add'
        ], [$this, 'sendEmail']);

        $this->getEventManager()->attach([
            'pre.add'
        ], [$this, 'preAdd']);

        $this->getEventManager()->attach([
            'pre.edit'
        ], [$this, 'preEdit']);

        $this->getEventManager()->attach([
            'post.edit'
        ], [$this, 'postEdit']);

        $this->getEventManager()->attach([
            'pre.save'
        ], [$this, 'preSave']);
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
                'recipient' => [
                    'name' => $user->getFullName(),
                    'address' => $user->getEmail(),
                ],
                'layout' => 'uthando-user/email/layout',
                'body' => $emailView,
                'subject' => 'Account Registration',
                'transport' => 'default',
            ]);
        }
    }

    /**
     * Registers a new user
     *
     * @param array $post
     * @return int|Form
     */
    public function register(array $post)
    {
        /* @var $form \UthandoUser\Form\Register */
        $form = $this->getForm('UthandoUserRegister');

        $model = $this->getModel();
        $model->setRole('registered');

        $form->setHydrator($this->getHydrator());
        $form->bind($model);

        /* @var $inputFilter \UthandoUser\InputFilter\User */
        $inputFilter = $this->getInputFilter();
        $inputFilter->addEmailNoRecordExists();
        $inputFilter->addPasswordLength('register');

        $form->setInputFilter($inputFilter);

        return $this->add($post, $form);
    }

    /**
     * Allows not admin user to edit thier profile
     *
     * @param UserModel $model
     * @param array $post
     * @return int|\UthandoUser\Form\UserEdit
     * @throws UthandoUserException
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function editUser(UserModel $model, array $post)
    {
        if (!$model instanceof UserModel) {
            throw new UthandoUserException('$model must be an instance of UthandoUser\Model\User, ' . get_class($model) . ' given.');
        }

        $model->setDateModified();

        /* @var $form \UthandoUser\Form\UserEdit */
        $form = $this->getForm('UthandoUserEdit');

        $form->setHydrator($this->getHydrator());
        $form->bind($model);

        /* @var $inputFilter \UthandoUser\InputFilter\User */
        $inputFilter = $this->getInputFilter();

        // we need to find if this email has changed,
        // if not then exclude it from validation,
        // if changed then reevaluate it.
        $email = ($model->getEmail() === $post['email']) ? $model->getEmail() : null;

        $inputFilter->addEmailNoRecordExists($email);

        $form->setInputFilter($inputFilter);

        $form->setData($post);
        $form->setValidationGroup([
            'firstname', 'lastname', 'email', 'userId', 'security'
        ]);

        if (!$form->isValid()) {
            return $form;
        }

        $saved = $this->save($form->getData());

        $this->updateSession($saved, $model);

        return $saved;

    }

    /**
     * Allows user to edit thier password
     *
     * @param array $post
     * @param UserModel $user
     * @return int|Form
     */
    public function changePassword(array $post, UserModel $user)
    {
        /* @var $form \UthandoUser\Form\UserEdit */
        $form = $this->getForm('UthandoUserPassword');

        /* @var $inputFilter \UthandoUser\InputFilter\User */
        $inputFilter = $this->getInputFilter();

        $inputFilter->addPasswordLength('register');

        $form->setHydrator($this->getHydrator());
        $form->setInputFilter($inputFilter);

        $form->setData($post);
        $form->bind($user);
        $form->setValidationGroup(['passwd', 'passwd-confirm', 'security']);

        if (!$form->isValid()) {
            return $form;
        }

        $user->setDateModified();

        $saved = $this->save($form->getData());

        return $saved;
    }

    /**
     * Update the session if user has updated their profile
     *
     * @param int $saved
     * @param UserModel $model
     */
    private function updateSession($saved, UserModel $model)
    {
        /* @var $auth \Zend\Authentication\AuthenticationService */
        $auth = $this->getService('Zend\Authentication\AuthenticationService');
        $identity = $auth->getIdentity();

        // if user has updated this details write the update model to session
        if ($saved && $model instanceof UserModel && $model->getUserId() === $identity->getUserId()) {
            $auth->getStorage()->write($model);
        }
    }

    /**
     * Pre user add checks
     *
     * @param Event $e
     */
    public function preAdd(Event $e)
    {
        $form = $e->getParam('form');
        /* @var $inputFilter \UthandoUser\InputFilter\User */
        $inputFilter = $form->getInputFilter();
        $inputFilter->addEmailNoRecordExists();
        $inputFilter->addPasswordLength('register');
        $form->setValidationGroup([
            'firstname', 'lastname', 'email', 'passwd', 'passwd-confirm', 'role', 'security',
        ]);
    }

    /**
     * prepare data to be updated and saved into database.
     *
     * @param Event $e
     */
    public function preEdit(Event $e)
    {
        $model = $e->getParam('model');
        $form = $e->getParam('form');
        $post = $e->getParam('post');

        $model->setDateModified();

        // we need to find if this email has changed,
        // if not then exclude it from validation,
        // if changed then reevaluate it.
        $email = ($model->getEmail() === $post['email']) ? $model->getEmail() : null;

        /* @var $inputFilter \UthandoUser\InputFilter\User */
        $inputFilter = $form->getInputFilter();
        $inputFilter->addEmailNoRecordExists($email);

        $form->setValidationGroup([
            'firstname', 'lastname', 'email', 'userId', 'active', 'role', 'security'
        ]);
    }

    /**
     * Post edit to update user session
     *
     * @param Event $e
     */
    public function postEdit(Event $e)
    {
        $this->updateSession($e->getParam('saved', false), $e->getParam('model'));
    }

    /**
     * Password pre saving checks
     *
     * @param Event $e
     * @throws UthandoUserException
     */
    public function preSave(Event $e)
    {
        $data = $e->getParam('data');

        if ($data instanceof UserModel) {
            $data = $this->getMapper()->extract($data);
        }

        if (array_key_exists('passwd', $data) && '' != $data['passwd']) {
            $data['passwd'] = $this->createPassword($data['passwd']);
        } else {
            unset($data['passwd']);
        }

        $e->setParam('data', $data);
    }

    /**
     * Create a new password hash
     *
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

    /**
     * Set and email new random password for user
     *
     * @param array $post
     * @return int|\UthandoUser\Form\ForgotPassword
     */
    public function forgotPassword(array $post)
    {
        $email          = (isset($post['email'])) ? $post['email'] : null;
        $user           = $this->getUserByEmail($email);
        /* @var $inputFilter \UthandoUser\InputFilter\User */
        $inputFilter    = $this->getInputFilter();
        /* @var $form \UthandoUser\Form\ForgotPassword */
        $form           = $this->getServiceLocator()
            ->get('FormElementManager')
            ->get('UthandoUserForgotPassword');

        //$inputFilter->addEmailNoRecordExists();
        $form->setValidationGroup(['email', 'captcha', 'security']);
        $form->setInputFilter($inputFilter);
        $form->setData($post);

        if (!$form->isValid()) {
            return $form;
        }

        return $this->resetPassword($user);
    }

    /**
     * Get user by their email
     *
     * @param $email
     * @param null $ignore
     * @param bool $emptyPassword
     * @param bool $activeOnly
     * @return null|UserModel
     */
    public function getUserByEmail($email, $ignore = null, $emptyPassword = true, $activeOnly = false)
    {
        $email = (string)$email;
        /* @var $mapper \UthandoUser\Mapper\User */
        $mapper = $this->getMapper();
        return $mapper->getUserByEmail($email, $ignore, $emptyPassword, $activeOnly);
    }

    /**
     * Reset user password for admin and email user with new random password
     *
     * @param UserModel $user
     * @return int
     */
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
                'recipient' => [
                    'name' => $user->getFullName(),
                    'address' => $user->getEmail(),
                ],
                'layout' => 'uthando-user/email/layout',
                'body' => $emailView,
                'subject' => 'Reset Password',
                'transport' => 'default',
            ]);
        }

        return $result;

    }

    /**
     * Delete user from database
     *
     * @param int $id
     * @return int
     * @throws \UthandoUser\UthandoUserException
     * @deprecated moving to event listener
     */
    public function delete($id)
    {
        $id = (int)$id;

        /* @var $auth \Zend\Authentication\AuthenticationService */
        $auth = $this->getService('Zend\Authentication\AuthenticationService');
        $identity = $auth->getIdentity();

        // sanity check to see if we are deleting ourselves!
        if ($id == $identity->getUserId()) {
            throw new UthandoUserException('You cannot delete yourself!');
        }

        return parent::delete($id);
    }
}
