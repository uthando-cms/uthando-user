<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 05/12/17 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace UthandoUser\Hydrator;

use UthandoCommon\Hydrator\BaseHydrator;

class LimitLoginHydrator extends BaseHydrator
{
    protected $map = [
        'id'            => 'id',
        'ip'            => 'ip',
        'attempts'      => 'attempts',
        'attempt_time'  => 'attemptTime',
        'locked_time'   => 'lockedTime',
    ];
}
