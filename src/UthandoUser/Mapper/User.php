<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Mapper
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoUser\Mapper;

use UthandoCommon\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Select;

/**
 * Class User
 *
 * @package UthandoUser\Mapper
 */
class User extends AbstractDbMapper
{ 
	protected $table = 'user';
	protected $primary = 'userId';

    /**
     * @param int $id
     * @param null $col
     * @return array|\UthandoUser\Model\User
     */
	public function getById($id, $col = null)
	{
        /* @var $hydrator \UthandoUser\Hydrator\User */
        $hydrator = $this->getResultSet()->getHydrator();
		$hydrator->emptyPassword();
		return parent::getById($id);
	}

    /**
     * @param string $email
     * @param null|string $ignore
     * @param bool $emptyPassword
     * @param bool $activeOnly
     * @return array|\ArrayObject|null|object
     */
    public function getUserByEmail($email, $ignore=null, $emptyPassword=true, $activeOnly=false)
    {
        if ($emptyPassword) {
            /* @var $hydrator \UthandoUser\Hydrator\User */
            $hydrator = $this->getResultSet()->getHydrator();
            $hydrator->emptyPassword();
        }
    	
        $select = $this->getSelect()
        	->where(['email' => $email]);
        
        if ($ignore) {
        	$select->where->notEqualTo('email', $ignore);
        }

        if ($activeOnly) {
            $select->where->equalTo('active', 1);
        }
        
        $rowSet = $this->fetchResult($select);
        $row = $rowSet->current();
        
        return $row;
    }

    /**
     * @param array $search
     * @param string $sort
     * @param Select $select
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function search(array $search, $sort, $select = null)
    {	
    	if (str_replace('-', '', $sort) == 'name') {
    		if (strchr($sort,'-')) {
    			$sort = ['-lastname', '-firstname'];
    		} else {
    			$sort = ['lastname', 'firstname'];
    		}
    	}
    
    	return parent::search($search, $sort, $select);
    }
}
