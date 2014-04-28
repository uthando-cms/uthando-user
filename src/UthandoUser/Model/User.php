<?php
namespace UthandoUser\Model;

use UthandoCommon\Model\ModelInterface;
use UthandoCommon\Model\Model;
use Zend\Permissions\Acl\Role\RoleInterface;
use DateTime;

class User implements RoleInterface, ModelInterface
{   
    use Model;
    
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
	 * @var DateTime
	 */
	protected $dateCreated;
	
	/**
	 * @var DateTime
	 */
	protected $dateModified;
	
    /**
	 * @return the $userId
	 */
	public function getUserId()
	{
		return $this->userId;
	}

	/**
	 * @param number $userId
	 */
	public function setUserId($userId)
	{
		$this->userId = $userId;
		return $this;
	}

	/**
	 * @return the $firstname
	 */
	public function getFirstname()
	{
		return $this->firstname;
	}

	/**
	 * @param string $firstname
	 */
	public function setFirstname($firstname)
	{
		$this->firstname = $firstname;
		return $this;
	}

	/**
	 * @return the $lastmane
	 */
	public function getLastname()
	{
		return $this->lastname;
	}

	/**
	 * @param string $lastmane
	 */
	public function setLastname($lastname)
	{
		$this->lastname = $lastname;
		return $this;
	}

	/**
	 * @return the $email
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 */
	public function setEmail($email)
	{
		$this->email = $email;
		return $this;
	}

	/**
	 * @return the $passwd
	 */
	public function getPasswd()
	{
		return $this->passwd;
	}

	/**
	 * @param string $passwd
	 */
	public function setPasswd($passwd)
	{
		$this->passwd = $passwd;
		return $this;
	}

	/**
	 * @return the $role
	 */
	public function getRole()
	{
		return $this->role;
	}

	/**
	 * @param string $role
	 */
	public function setRole($role)
	{
		$this->role = $role;
		return $this;
	}

	/**
	 * @return the $dateCreated
	 */
	public function getDateCreated()
	{
		return $this->dateCreated;
	}

	/**
	 * @param DateTime $dateCreated
	 */
	public function setDateCreated(DateTime $dateCreated=null)
	{
		$this->dateCreated = $dateCreated;
		return $this;
	}

	/**
	 * @return the $dateModified
	 */
	public function getDateModified()
	{
		return $this->dateModified;
	}

	/**
	 * @param DateTime $dateModified
	 */
	public function setDateModified(DateTime $dateModified=null)
	{
		$this->dateModified = $dateModified;
		return $this;
	}
	
	public function getRoleId()
	{
	    return $this->getRole();
	}

	public function getFullName()
    {
    	return $this->getFirstname() . ' ' . $this->getLastname();
    }
    
    public function getLastNameFirst()
    {
    	return $this->getLastname() . ', ' . $this->getFirstname();
    }
}
