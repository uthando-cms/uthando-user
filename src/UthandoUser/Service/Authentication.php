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

use UthandoUser\Authentication\Adapter as AuthAdapter;
use UthandoUser\Authentication\Storage;
use UthandoUser\Model\UserModel as UserModel;
use UthandoUser\Options\AuthOptions;
use Zend\Authentication\AuthenticationService as ZendAuthenticationService;

/**
 * Class Authentication
 *
 * @package UthandoUser\Service
 * @method UserModel getIdentity()
 * @method Storage getStorage()
 */
class Authentication extends ZendAuthenticationService
{
    /**
     * @var AuthAdapter
     */
    protected $authAdapter;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var LimitLoginService
     */
    protected $limitLoginService;

    /**
     * @var AuthOptions
     */
    protected $options;

    /**
     * @return UserService
     */
    public function getUserService(): UserService
    {
        return $this->userService;
    }

    public function setUserService(UserService $service): Authentication
    {
        $this->userService = $service;
        return $this;
    }

    public function getLimitLoginService(): LimitLoginService
    {
        return $this->limitLoginService;
    }

    public function setLimitLoginService(LimitLoginService $limitLoginService): Authentication
    {
        $this->limitLoginService = $limitLoginService;
        return $this;
    }

    public function getOptions(): AuthOptions
    {
        return $this->options;
    }

    public function setOptions(AuthOptions $options): void
    {
        $this->options = $options;
    }

    public function doAuthentication(string $identity, string $password): bool
    {
        $authMethod = $this->getOptions()->getAuthenticateMethod();
        $user = $this->getUserService()->$authMethod(
            $identity,
            null,
            false,
            true
        );

        if (!$user) {
            return false;
        }

        // hash the password and verify.
        $adapter = $this->getAuthAdapter($password, $user);
        $result = $this->authenticate($adapter);

        if (!$result->isValid()) {
            return false;
        }

        $user = $result->getIdentity();

        if (in_array('update password', $result->getMessages())) {
            $user->setPasswd($password);
            $user->setDateModified();
            $this->getUserService()->save($user);
        }

        $user->setPasswd(null);

        $this->getStorage()->write($user);

        return true;
    }

    public function checkIp()
    {

    }

    public function getAuthAdapter(string $password, UserModel $user): AuthAdapter
    {
        if (null === $this->authAdapter) {

            $authAdapter = new AuthAdapter();

            $authAdapter->setIdentity($user);
            $authAdapter->setCredential($password);
            $authAdapter->setCredentialTreatment($this->getOptions()->getCredentialTreatment());

            if ($this->getOptions()->isUseFallbackTreatment()) {
                $authAdapter->setUseFallback($this->getOptions()->isUseFallbackTreatment());
                $authAdapter->setFallbackCredentialTreatment($this->getOptions()->getFallbackCredentialTreatment());
            }

            $this->setAuthAdapter($authAdapter);
        }

        return $this->authAdapter;
    }

    public function setAuthAdapter(AuthAdapter $adapter): void
    {
        $this->authAdapter = $adapter;
    }

    public function clear(): void
    {
        $this->getStorage()->forgetMe();
        $this->clearIdentity();
    }
}
