<?php
namespace UthandoUser\Service;

use Zend\Form\Form;
use UthandoCommon\Model\ModelInterface;
use UthandoCommon\Service\AbstractService;
use UthandoUser\UthandoUserException;
use UthandoUser\Model\User as UserModel;
use Zend\Crypt\Password\PasswordInterface;

class User extends AbstractService
{   
	protected $mapperClass = 'UthandoUser\Mapper\User';
	protected $form = 'UthandoUser\Form\User';
	protected $inputFilter = 'UthandoUser\InputFilter\User';
    
    public function getUserByEmail($email, $ignore=null, $emptyPassword = true)
    {
    	$email = (string) $email;
    	return $this->getMapper()->getUserByEmail($email, $ignore, $emptyPassword);
    }
    
    public function add(array $post, Form $form = null)
    {
        $form = $this->getForm($this->getMapper()->getModel(), $post, true, true);
        $form->getInputFilter()->addEmailNoRecordExists();
        
        $saved = parent::add($post, $form);
        
        if (!$saved instanceof Form && $saved) {
            $this->getEventManager()->trigger('user.add', get_class($this), $post);
        }
        
        return $saved;
    }
    
    /**
	 * prepare data to be updated and saved into database.
	 * 
	 * @param UserModel $model
	 * @param array $post
	 * @param Form $form
	 * @return int results from self::save()
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
    	// if changed then revalidate it.
    	$email = ($model->getEmail() === $post['email']) ? $model->getEmail() : null;
    	
    	$form->getInputFilter()->addEmailNoRecordExists($email);
    	
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
     * @return Ambigous <object, multitype:, \User\Form\Password>
     */
    public function changePasswd(array $post, UserModel $user)
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
    
    public function delete($id)
    {
        // sanity check to see if we are deleting yourselfs!
        $id = (int) $id;
        
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        $identity = $auth->getIdentity();
        
        if ($id == $identity->getUserId()) {
            throw new UthandoUserException('You cannot delete yourself!');
        }
        
        return parent::delete($id);
    }
    
    public function createPassword($password)
    {
        $authOptions = $this->getConfig('user');
        
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
