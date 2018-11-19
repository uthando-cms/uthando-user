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
use UthandoUser\Model\UserModel;
use UthandoUser\Service\Acl;

class IsAllowed extends AbstractViewHelper
{
    /**
     * @var PluginIsAllowed
     */
    protected $pluginIsAllowed;

    public function __invoke(?string $resource, ?string $privilege): bool
    {
        return $this->isAllowed($resource, $privilege);
    }

    private function isAllowed(?string $resource, ?string $privilege): bool
    {
        $acl = $this->getPluginIsAllowed();
        return $acl->isAllowed($resource, $privilege);
    }

    private function setPluginIsAllowed(PluginIsAllowed $pluginIsAllowed): IsAllowed
    {
        $this->pluginIsAllowed = $pluginIsAllowed;
        return $this;
    }

    private function getPluginIsAllowed(): PluginIsAllowed
    {
        if (!$this->pluginIsAllowed instanceof PluginIsAllowed) {
            /* @var $acl Acl */
            $acl = $this->getServiceLocator()
                ->getServiceLocator()
                ->get(Acl::class);
            /* @var $identity UserModel|null */
            $identity = $this->getView()->plugin('identity')();

            $pluginIsAllowed = new PluginIsAllowed();
            $pluginIsAllowed->setAcl($acl);
            $pluginIsAllowed->setIdentity($identity);
            $this->setPluginIsAllowed($pluginIsAllowed);
        }

        return $this->pluginIsAllowed;
    }
}
