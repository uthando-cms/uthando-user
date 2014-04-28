<?php
namespace UthandoUser\Mapper;

use UthandoCommon\Mapper\AbstractMapper;
use Zend\Db\Sql\Select;

class User extends AbstractMapper
{ 
	protected $table = 'user';
	protected $primary = 'userId';
	protected $model= 'UthandoUser\Model\User';
	protected $hydrator = 'UthandoUser\Hydrator\User';
	
	public function getById($id)
	{
		$this->getResultSet()->getHydrator()->emptyPassword();
		return parent::getById($id);
	}
    
    public function getUserByEmail($email, $ignore=null, $emptyPassword = true)
    {
        if ($emptyPassword) {
            $this->getResultSet()->getHydrator()->emptyPassword();
        }
    	
        $select = $this->getSelect()
        	->where(['email' => $email]);
        
        if ($ignore) {
        	$select->where->notEqualTo('email', $ignore);
        }
        
        $rowset = $this->fetchResult($select);
        $row = $rowset->current();
        
        return $row;
    }
    
    public function search(array $search, $sort, Select $select = null)
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
