<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Form\Element
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Form\Element;

use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class AbstractResourceList
 *
 * @package UthandoUser\Form\Element
 */
abstract class AbstractResourceList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @var string
     */
    protected $resource;

    /**
     * @var string
     */
    protected $emptyOption = 'None';

    /**
     * @return void
     */
    public function init(): void
    {
        $config = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('config');

        $resources = $config['uthando_user']['acl']['resources'];

        $regex = '/^' . $this->resource . ':/';

        $resources = preg_grep($regex, $resources);

        $this->setValueOptions($this->getResources($resources));
    }

    public function getResources(array $resources): array
    {
        $routeArray = [];

        foreach ($resources as $val) {
            $routeArray[$val] = $val;
        }

        return $routeArray;
    }

    public function getResource(): string
    {
        return $this->resource;
    }

    public function setResource(string $resource): AbstractResourceList
    {
        $this->resource = $resource;
        return $this;
    }
}
