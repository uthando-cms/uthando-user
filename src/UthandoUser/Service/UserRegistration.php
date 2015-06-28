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

namespace UthandoUser\Service;

use UthandoCommon\Service\AbstractRelationalMapperService;
use Zend\View\Model\ViewModel;

/**
 * Class UserController
 *
 * @package UthandoUser\Controller
 * @method \Zend\Session\Container sessionContainer()
 */
class UserRegistration extends AbstractRelationalMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'UthandoUserRegistration';
    
    /**
     * @var array
     */
    protected $referenceMap = [
        'user'  => [
            'refCol'    => 'userId',
            'service'   => 'UthandoUser',
        ],
    ];
    
    /**
     * @var bool
     */
    protected $useCache = false;
    
    /**
     * @param string $email
     */
    public function sendVerificationEmail($email)
    {
        $email = (string) $email;
        
        $user = $this->getUserService()->getUserByEmail($email);
        
        /* @var $registrationRecord \UthandoUser\Model\UserRegistration */
        $registrationRecord = $this->getModel();
        $registrationRecord->generateToken();
        $registrationRecord->setUserId($user->getUserId());
        $registrationRecord->setUser($user);
        
        $this->save($registrationRecord);
        
        $emailView = new ViewModel([
            'registrationRecord' => $registrationRecord,
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
    }
    
    /**
     * @param string $token
     * @param string $email
     * @return boolean
     */
    public function verify($token, $email)
    {
        $token = (string) $token;
        $email = (string) $email;
        
        $user = $this->getUserService()->getUserByEmail($email);
        $registrationRecord = $this->getById($user->getUserId(), 'userId');
        
        if ($registrationRecord->getToken() === $token) {
            $this->delete($registrationRecord->getUserRegistrationId());
            $user->setActive(true);
            $result = $this->getUserService()->save($user);
            
            if ($result) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * @return \UthandoUser\Service\User
     */
    public function getUserService()
    {
        return $this->getRelatedService('user');
    }
}
