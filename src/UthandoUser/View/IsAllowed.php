<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\View
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\View;

use UthandoCommon\View\AbstractViewHelper;
use UthandoUser\Controller\Plugin\IsAllowed as PluginIsAllowed;
use UthandoUser\Service\Acl;

class IsAllowed extends AbstractViewHelper
{
    /**
     * @var PluginIsAllowed
     */
    protected $pluginIsAllowed;

    public function __invoke($resource = null, $privilege = null): Acl
    {
        return $this->isAllowed($resource, $privilege);
    }

    public function __call(string $method, array $argv)
    {
        $acl = $this->getPluginIsAllowed();
        return call_user_func_array([$acl, $method], $argv);
    }

    public function getPluginIsAllowed(): PluginIsAllowed
    {
        if ($this->pluginIsAllowed) {
            return $this->pluginIsAllowed;
        }

        $acl = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(Acl::class);
        $identity = $this->view->plugin('identity');

        $this->pluginIsAllowed = new PluginIsAllowed($acl);
        $this->pluginIsAllowed->setIdentity($identity());

        return $this->pluginIsAllowed;
    }
}
