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
 * Class RoleList
 *
 * @package UthandoUser\Form\Element
 */
class RoleList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    protected $emptyOption = '---Please choose a user role---';

    public function getValueOptions()
    {
        return ($this->valueOptions) ?: $this->getRoles();
    }

    public function getRoles()
    {
        $config = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('config');
        $roles = $config['uthando_user']['acl']['roles'];
        $roleOptions = [];

        foreach($roles as $key => $value) {
            $roleOptions[] = [
                'label' => $value['label'],
                'value' => $key,
            ];
        }

        return $roleOptions;
    }
}
