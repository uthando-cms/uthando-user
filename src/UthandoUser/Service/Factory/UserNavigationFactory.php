<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Service\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */
namespace UthandoUser\Service\Factory;

use Zend\Navigation\Service\AbstractNavigationFactory;

/**
 * Class UserNavigationFactory
 * @package UthandoUser\Service\Factory
 */
class UserNavigationFactory extends AbstractNavigationFactory
{
	protected function getName()
	{
		return 'user';
	}
}
