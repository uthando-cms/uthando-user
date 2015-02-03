<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Hydrator
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */
namespace UthandoUser\Hydrator;

use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoCommon\Hydrator\Strategy\DateTime as DateTimeStrategy;
use UthandoCommon\Hydrator\Strategy\EmptyString;
use UthandoCommon\Hydrator\Strategy\TrueFalse;

/**
 * Class User
 * @package UthandoUser\Hydrator
 */
class User extends AbstractHydrator
{   
	public function __construct()
	{
		parent::__construct();
		
		$dateTime = new DateTimeStrategy();
		
		$this->addStrategy('dateCreated', $dateTime);
		$this->addStrategy('dateModified', $dateTime);
		$this->addStrategy('active', new TrueFalse());
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
			'active'		=> $this->extractValue('active', $object->getActive()),
		];
	}
}
