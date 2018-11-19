<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Form\Element
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Form\Element;

use UthandoCommon\Service\ServiceManager;
use UthandoUser\Service\UserService;
use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class UserList
 *
 * @package UthandoUser\Form\Element
 */
class UserList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    protected $emptyOption = '---Please select a user---';

    public function getValueOptions(): array
    {
        return ($this->valueOptions) ?: $this->getUsers();
    }

    public function getUsers(): array
    {
        $users = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class)
            ->get(UserService::class)
            ->fetchAll();

        $userOptions = [];

        /* @var $user \UthandoUser\Model\UserModel */
        foreach ($users as $user) {
            $userOptions[] = [
                'label' => $user->getFullName(),
                'value' => $user->getUserId(),
            ];
        }

        return $userOptions;
    }
}
