<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 04/12/17 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoUser\Mapper;

use UthandoCommon\Mapper\AbstractDbMapper;
use UthandoUser\Model\LimitLoginModel;

class LimitLoginMapper extends AbstractDbMapper
{
    protected $table = 'limit_login';
    protected $primary = 'id';

    public function getLoginByIp(string $ip): LimitLoginModel
    {
        $select = $this->getSelect();
        $select->where->equalTo('ip', $ip);

        $rowSet = $this->fetchResult($select);
        $row = $rowSet->current() ?: new LimitLoginModel();

        return $row;
    }
}
