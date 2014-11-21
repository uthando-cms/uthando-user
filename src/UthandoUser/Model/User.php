<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Model
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */
namespace UthandoUser\Model;

use UthandoCommon\Model\DateCreatedTrait;
use UthandoCommon\Model\DateModifiedTrait;
use UthandoCommon\Model\ModelInterface;
use UthandoCommon\Model\Model;
use Zend\Permissions\Acl\Role\RoleInterface;

/**
 * Class User
 * @package UthandoUser\Model
 */
class User implements RoleInterface, ModelInterface
{   
    use Model,
        DateCreatedTrait,
        DateModifiedTrait;
    
	/**
	 * @var int
	 */
	protected $userId;
	
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
     * @return int
     */
	public function getUserId()
	{
		return $this->userId;
	}

    /**
     * @param int $userId
     * @return $this
     */
	public function setUserId($userId)
	{
		$this->userId = $userId;
		return $this;
	}

    /**
     * @return string
     */
	public function getFirstname()
	{
		return $this->firstname;
	}

    /**
     * @param string $firstname
     * @return $this
     */
	public function setFirstname($firstname)
	{
		$this->firstname = $firstname;
		return $this;
	}

    /**
     * @return string
     */
	public function getLastname()
	{
		return $this->lastname;
	}

    /**
     * @param string $lastname
     * @return $this
     */
	public function setLastname($lastname)
	{
		$this->lastname = $lastname;
		return $this;
	}

    /**
     * @return string
     */
	public function getEmail()
	{
		return $this->email;
	}

    /**
     * @param string $email
     * @return $this
     */
	public function setEmail($email)
	{
		$this->email = $email;
		return $this;
	}

    /**
     * @return string
     */
	public function getPasswd()
	{
		return $this->passwd;
	}

    /**
     * @param string $passwd
     * @return $this
     */
	public function setPasswd($passwd)
	{
		$this->passwd = $passwd;
		return $this;
	}

    /**
     * @return string
     */
	public function getRole()
	{
		return $this->role;
	}

    /**
     * @param string $role
     * @return $this
     */
	public function setRole($role)
	{
		$this->role = $role;
		return $this;
	}

    /**
     * @return string
     */
	public function getRoleId()
	{
	    return $this->getRole();
	}

    /**
     * @return string
     */
	public function getFullName()
    {
    	return $this->getFirstname() . ' ' . $this->getLastname();
    }

    /**
     * @return string
     */
    public function getLastNameFirst()
    {
    	return $this->getLastname() . ', ' . $this->getFirstname();
    }
}
