<?php
namespace UthandoUser\Hydrator;

use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoCommon\Hydrator\Strategy\DateTime as DateTimeStrategy;
use UthandoCommon\Hydrator\Strategy\EmptyString;

class User extends AbstractHydrator
{
    protected $prefix = 'user.';
    
	public function __construct()
	{
		parent::__construct();
		
		$dateTime = new DateTimeStrategy();
		
		$this->addStrategy('dateCreated', $dateTime);
		$this->addStrategy('dateModified', $dateTime);
		return $this;
	}
	
	public function emptyPassword()
	{
		$this->addStrategy('passwd', new EmptyString());
		return $this;
	}
	
	/**
	 * @param \UthandoUser\Model\User $object
	 * @return array
	 */
	public function extract($object)
	{
		return [
			'userId'		=> $object->getUserId(),
			'firstname'		=> $object->getFirstname(),
			'lastname'		=> $object->getLastname(),
			'email'			=> $object->getEmail(),
			'passwd'		=> $this->extractValue('passwd', $object->getPasswd()),
			'role'			=> $object->getRole(),
			'dateCreated'	=> $this->extractValue('dateCreated', $object->getDateCreated()),
			'dateModified'	=> $this->extractValue('dateModified', $object->getDateModified()),
		];
	}
}