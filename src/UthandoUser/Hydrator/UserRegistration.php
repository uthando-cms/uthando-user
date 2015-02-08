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
use UthandoCommon\Hydrator\Strategy\DateTime;
use UthandoCommon\Hydrator\Strategy\TrueFalse;

/**
 * Class UserRegistration
 * @package UthandoUser\Hydrator
 */
class UserRegistration extends AbstractHydrator
{
    public function __construct()
    {
        parent::__construct();
        
        $this->addStrategy('requestTime', new DateTime());
        $this->addStrategy('responded', new TrueFalse());
        
        return $this;
    }
    
    /**
     * @param \UthandoUser\Model\UserRegistration $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'userRegistrationId'    => $object->getUserRegistrationId(),
            'userId'                => $object->getUserId(),
            'token'                 => $object->getToken(),
            'requestTime'           => $this->extractValue('requestTime', $object->getRequestTime()),
            'responded'             => $this->extractValue('responded', $object->getResponded()),
        ];
    }
}
