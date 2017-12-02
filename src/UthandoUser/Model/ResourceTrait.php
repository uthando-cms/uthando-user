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

use UthandoCommon\Model\ModelInterface;

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

    public function getResource(): string
    {
        return $this->resource;
    }

    public function setResource(string $resource): ModelInterface
    {
        $this->resource = $resource;
        return $this;
    }
}
