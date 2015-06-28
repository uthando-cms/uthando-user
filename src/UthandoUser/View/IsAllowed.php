<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\View
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoUser\View;

use UthandoCommon\View\AbstractViewHelper;
use UthandoUser\Controller\Plugin\IsAllowed as PluginIsAllowed;

/**
 * Class IsAllowed
 *
 * @package UthandoUser\View
 */
class IsAllowed extends AbstractViewHelper
{
    /**
     * @var PluginIsAllowed
     */
    protected $pluginIsAllowed;
    
    /**
     * Returns the acl plugin instance
     *
     * @return Acl
     */
    public function __invoke($resource = null, $privilege = null)
    {
        return $this->isAllowed($resource, $privilege);
    }
    
    /**
     * Proxy the acl plugin controller
     *
     * @param  string $method
     * @param  array  $argv
     * @return mixed
     */
    public function __call($method, $argv)
    {
        $acl = $this->getPluginIsAllowed();
        return call_user_func_array([$acl, $method], $argv);
    }
    
    /**
     * Retrieve the acl plugin
     *
     * @return PluginIsAllowed
     */
    public function getPluginIsAllowed()
    {
        if ($this->pluginIsAllowed) {
            return $this->pluginIsAllowed;
        }
        
        $acl = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('UthandoUser\Service\Acl');
        $identity = $this->view->plugin('identity');
    
        $this->pluginIsAllowed = new PluginIsAllowed($acl);
        $this->pluginIsAllowed->setIdentity($identity());
    
        return $this->pluginIsAllowed;
    }
}

