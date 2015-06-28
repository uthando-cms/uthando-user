<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Form\Element
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoUser\Form\Element;

use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class UserList
 * @package UthandoUser\Form\Element
 */
class UserList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    protected $emptyOption = '---Please select a user---';

    public function getValueOptions()
    {
        return ($this->valueOptions) ?: $this->getUsers();
    }

    public function getUsers()
    {
        $users = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('UthandoServiceManager')
            ->get('UthandoUser')
            ->fetchAll();

        $userOptions = [];

        /* @var $user \UthandoUser\Model\User */
        foreach($users as $user) {
            $userOptions[] = [
                'label' => $user->getFullName(),
                'value' => $user->getUserId(),
            ];
        }

        return $userOptions;
    }
}
