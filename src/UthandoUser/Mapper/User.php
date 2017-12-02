<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Mapper
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Mapper;

use UthandoCommon\Mapper\AbstractDbMapper;
use UthandoUser\Model\User as UserModel;
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
     * @return array|UserModel
     */
    public function getById($id, $col = null)
    {
        /* @var $hydrator \UthandoUser\Hydrator\User */
        $hydrator = $this->getResultSet()->getHydrator();
        $hydrator->emptyPassword();
        return parent::getById($id);
    }

    public function getAdminUserByEmail(string $email): ?UserModel
    {
        $select = $this->getSelect();

        $select->where
            ->equalTo('email', $email)
            ->and
            ->equalTo('role', 'admin');

        $rowSet = $this->fetchResult($select);
        /* @var $row UserModel|null */
        $row    = $rowSet->current();

        return $row;
    }

    public function getUserByEmail(string $email, ?string $ignore, bool $emptyPassword, bool $activeOnly): UserModel
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
        $row    = $rowSet->current() ?: new UserModel();

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
            if (strchr($sort, '-')) {
                $sort = ['-lastname', '-firstname'];
            } else {
                $sort = ['lastname', 'firstname'];
            }
        }

        return parent::search($search, $sort, $select);
    }
}
