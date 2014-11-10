<?php
namespace UthandoUser\Form\Element;

use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

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
            ->get('UthandoUser\Service\User')
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
