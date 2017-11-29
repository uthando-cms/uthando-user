<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Model
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Model;

/**
 * Class ResourceTrait
 *
 * @package UthandoUser\Model
 */
trait ResourceTrait
{
    /**
     * @var string
     */
    protected $resource;

    /**
     * @return string
     */
    public function getResource(): string
    {
        return $this->resource;
    }

    /**
     * @param string $resource
     * @return $this
     */
    public function setResource(string $resource)
    {
        $this->resource = $resource;
        return $this;
    }
}
