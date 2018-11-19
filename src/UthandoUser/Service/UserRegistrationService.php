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

namespace UthandoUser\Service;

use UthandoCommon\Service\AbstractRelationalMapperService;
use UthandoUser\Hydrator\UserRegistrationHydrator;
use UthandoUser\Mapper\UserRegistrationMapper;
use UthandoUser\Model\UserRegistrationModel;
use Zend\View\Model\ViewModel;

/**
 * Class UserController
 *
 * @package UthandoUser\Controller
 * @method \Zend\Session\Container sessionContainer()
 */
class UserRegistrationService extends AbstractRelationalMapperService
{
    protected $hydrator     = UserRegistrationHydrator::class;
    protected $mapper       = UserRegistrationMapper::class;
    protected $model        = UserRegistrationModel::class;

    /**
     * @var array
     */
    protected $referenceMap = [
        'user' => [
            'refCol' => 'userId',
            'service' => UserService::class
        ],
    ];

    /**
     * @var bool
     */
    protected $useCache = false;

    public function sendVerificationEmail(string $email): void
    {
        $user = $this->getUserService()->getUserByEmail(
            $email,
            null,
            true,
            false
        );

        /* @var $registrationRecord \UthandoUser\Model\UserRegistrationModel */
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
            'recipient' => [
                'name' => $user->getFullName(),
                'address' => $user->getEmail(),
            ],
            'layout' => 'uthando-user/email/layout',
            'body' => $emailView,
            'subject' => 'Verify Account',
            'transport' => 'default',
        ]);
    }

    public function getUserService(): UserService
    {
        return $this->getRelatedService('user');
    }

    public function verify(string $token, string $email): bool
    {
        $user = $this->getUserService()->getUserByEmail(
            $email,
            null,
            true,
            false
        );
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
}
