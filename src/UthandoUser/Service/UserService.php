<?php declare(strict_types=1);
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

use UthandoUser\Form\ForgotPasswordForm;
use UthandoUser\Form\PasswordForm;
use UthandoUser\Form\RegisterForm;
use UthandoUser\Form\UserEditForm;
use UthandoUser\Form\UserForm;
use UthandoUser\Hydrator\UserHydrator;
use UthandoUser\InputFilter\UserInputFilter;
use UthandoUser\Mapper\UserMapper;
use UthandoUser\Model\UserModel;
use UthandoCommon\Service\AbstractMapperService;
use UthandoUser\Options\AuthOptions;
use UthandoUser\UthandoUserException;
use Zend\Authentication\AuthenticationService;
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
class UserService extends AbstractMapperService
{
    protected $form         = UserForm::class;
    protected $hydrator     = UserHydrator::class;
    protected $inputFilter  = UserInputFilter::class;
    protected $mapper       = UserMapper::class;
    protected $model        = UserModel::class;

    /**
     * @var bool
     */
    //protected $useCache = false;

    public function attachEvents(): void
    {
        $this->getEventManager()->attach('post.add', [$this, 'sendEmail']);
        $this->getEventManager()->attach('pre.add', [$this, 'preAdd']);
        $this->getEventManager()->attach('pre.edit', [$this, 'preEdit']);
        $this->getEventManager()->attach('post.edit', [$this, 'postEdit']);
        $this->getEventManager()->attach('pre.save', [$this, 'preSave']);
    }

    public function sendEmail(Event $e): void
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
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function register(array $post)
    {
        /* @var $form RegisterForm */
        $form = $this->getForm(RegisterForm::class);

        $model = $this->getModel();
        $model->setRole('registered');

        $form->setHydrator($this->getHydrator());
        $form->bind($model);

        /* @var $inputFilter \UthandoUser\InputFilter\UserInputFilter */
        $inputFilter = $this->getInputFilter();
        $form->setInputFilter($inputFilter);

        return $this->add($post, $form);
    }

    /**
     * Allows not admin user to edit thier profile
     *
     * @param UserModel $model
     * @param array $post
     * @return int|UserEditForm
     * @throws UthandoUserException
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function editUser(UserModel $model, array $post)
    {
        if (!$model instanceof UserModel) {
            throw new UthandoUserException('$model must be an instance of UthandoUser\Model\User, ' . get_class($model) . ' given.');
        }

        $model->setDateModified();

        /* @var $form UserEditForm */
        $form = $this->getForm(UserEditForm::class);

        $form->setHydrator($this->getHydrator());
        $form->bind($model);

        /* @var $inputFilter \UthandoUser\InputFilter\UserInputFilter */
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

    public function changePassword(array $post, UserModel $user)
    {
        /* @var $form PasswordForm */
        $form = $this->getForm(PasswordForm::class);

        /* @var $inputFilter \UthandoUser\InputFilter\UserInputFilter */
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

    private function updateSession(int $saved, UserModel $model): void
    {
        /* @var $auth AuthenticationService */
        $auth = $this->getService(AuthenticationService::class);
        $identity = $auth->getIdentity();

        // if user has updated this details write the update model to session
        if ($saved && $model instanceof UserModel && $model->getUserId() === $identity->getUserId()) {
            $auth->getStorage()->write($model);
        }
    }

    public function preAdd(Event $e): void
    {
        $form = $e->getParam('form');
        /* @var $inputFilter \UthandoUser\InputFilter\UserInputFilter */
        $inputFilter = $form->getInputFilter();
        $inputFilter->addEmailNoRecordExists(null);
        $inputFilter->addPasswordLength('register');
        $form->setValidationGroup([
            'firstname', 'lastname', 'email', 'passwd', 'passwd-confirm', 'role', 'security',
        ]);
    }

    public function preEdit(Event $e): void
    {
        $model = $e->getParam('model');
        $form = $e->getParam('form');
        $post = $e->getParam('post');

        $model->setDateModified();

        // we need to find if this email has changed,
        // if not then exclude it from validation,
        // if changed then reevaluate it.
        $email = ($model->getEmail() === $post['email']) ? $model->getEmail() : null;

        /* @var $inputFilter \UthandoUser\InputFilter\UserInputFilter */
        $inputFilter = $form->getInputFilter();
        $inputFilter->addEmailNoRecordExists($email);

        $form->setValidationGroup([
            'firstname', 'lastname', 'email', 'userId', 'active', 'role', 'security'
        ]);
    }

    public function postEdit(Event $e): void
    {
        $this->updateSession($e->getParam('saved', false), $e->getParam('model'));
    }

    public function preSave(Event $e): void
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

    public function createPassword(string $password): string
    {
        /* @var $authOptions AuthOptions */
        $authOptions = $this->getService(AuthOptions::class);

        if (!class_exists($authOptions->getCredentialTreatment())) {
            throw new UthandoUserException('Credential treatment must be an class name');
        } else {
            $cryptClass = $authOptions->getCredentialTreatment();
            $crypt      = new $cryptClass;
        }

        if (!$crypt instanceof PasswordInterface) {
            throw new UthandoUserException('Credential treatment must be an instance of Zend\Crypt\Password\PasswordInterface');
        }

        $password = $crypt->create($password);

        return $password;
    }

    public function forgotPassword(array $post)
    {
        $email          = (isset($post['email'])) ? $post['email'] : '';
        $user           = $this->getUserByEmail(
            $email,
            null,
            true,
            false
        );
        /* @var $inputFilter \UthandoUser\InputFilter\UserInputFilter */
        $inputFilter    = $this->getInputFilter();
        /* @var $form \UthandoUser\Form\ForgotPasswordForm */
        $form           = $this->getService('FormElementManager')
            ->get(ForgotPasswordForm::class);

        //$inputFilter->addEmailNoRecordExists();
        $form->setValidationGroup(['email', 'captcha', 'security']);
        $form->setInputFilter($inputFilter);
        $form->setData($post);

        if (!$form->isValid()) {
            return $form;
        }

        return $this->resetPassword($user);
    }

    public function getAdminUserByEmail(string $email, ?string $ignore, bool $emptyPassword, bool $activeOnly): ?UserModel
    {
        /* @var $mapper \UthandoUser\Mapper\UserMapper */
        $mapper = $this->getMapper();
        return $mapper->getAdminUserByEmail($email, $ignore, $emptyPassword, $activeOnly);
    }

    public function getUserByEmail(string $email, ?string $ignore, bool $emptyPassword, bool $activeOnly): ?UserModel
    {
        /* @var $mapper \UthandoUser\Mapper\UserMapper */
        $mapper = $this->getMapper();
        return $mapper->getUserByEmail($email, $ignore, $emptyPassword, $activeOnly);
    }

    public function resetPassword(UserModel $user): int
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

    public function delete($id): int
    {
        $id = (int)$id;

        /* @var $auth AuthenticationService */
        $auth = $this->getService(AuthenticationService::class);
        $identity = $auth->getIdentity();

        // sanity check to see if we are deleting ourselves!
        if ($id == $identity->getUserId()) {
            throw new UthandoUserException('You cannot delete yourself!');
        }

        return parent::delete($id);
    }
}
