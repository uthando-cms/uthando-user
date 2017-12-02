<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Model
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Model;

use UthandoCommon\Model\DateCreatedTrait;
use UthandoCommon\Model\DateModifiedTrait;
use UthandoCommon\Model\ModelInterface;
use UthandoCommon\Model\Model;
use Zend\Permissions\Acl\Role\RoleInterface;
use Zend\Math\Rand;

/**
 * Class User
 *
 * @package UthandoUser\Model
 */
class User implements RoleInterface, ModelInterface
{
    use Model,
        UserIdTrait,
        DateCreatedTrait,
        DateModifiedTrait;

    const PASSWORD_LENGTH = 12;

    /**
     * @var string
     */
    protected $firstname;

    /**
     * @var string
     */
    protected $lastname;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $passwd;

    /**
     * @var string
     */
    protected $role;

    /**
     * @var bool
     */
    protected $active = false;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getPasswd(): ?string
    {
        return $this->passwd;
    }

    public function setPasswd(?string $passwd): User
    {
        $this->passwd = $passwd;
        return $this;
    }

    public function generatePassword(): void
    {
        $password = Rand::getString(
            self::PASSWORD_LENGTH,
            'ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijklmnpqrstuvwxyz123456789'
        );

        $password = str_split($password, 3);
        $password = implode('-', $password);

        $this->setPasswd($password);
    }

    public function getRoleId(): ?string
    {
        return $this->getRole();
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): User
    {
        $this->role = $role;
        return $this;
    }

    public function getFullName(): string
    {
        return $this->getFirstname() . ' ' . $this->getLastname();
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): User
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): User
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getLastNameFirst(): string
    {
        return $this->getLastname() . ', ' . $this->getFirstname();
    }

    public function isActive(): string
    {
        return (true === $this->getActive()) ? 'yes' : 'no';
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): User
    {
        $this->active = $active;
        return $this;
    }
}
