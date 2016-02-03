<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUserTest\Form\Element
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUserTest\Form\Element;

use UthandoUserTest\Framework\ApplicationTestCase;

class AbstractResourceListTest extends ApplicationTestCase
{
    public $resources = [
        'menu:admin',
        'menu:guest',
        'menu:user',
    ];

    public function testInit()
    {
        /* @var \UthandoUser\Form\Element\AbstractResourceList $stub */
        $stub = $this->getMockForAbstractClass('UthandoUser\Form\Element\AbstractResourceList');

        $stub->setServiceLocator($this->getApplicationServiceLocator()->get('FormElementManager'));
        $stub->init();

        $this->assertInternalType('array', $stub->getValueOptions());
    }

    public function testGetResources()
    {
        /* @var \UthandoUser\Form\Element\AbstractResourceList $stub */
        $stub = $this->getMockForAbstractClass('UthandoUser\Form\Element\AbstractResourceList');
        $config = $this->getApplicationServiceLocator()->get('config');

        $resources = $config['uthando_user']['acl']['resources'];

        $this->assertInternalType('array', $stub->getResources($resources));
    }

    public function testSetGetResource()
    {
        /* @var \UthandoUser\Form\Element\AbstractResourceList $stub */
        $stub = $this->getMockForAbstractClass('UthandoUser\Form\Element\AbstractResourceList');

        $stub->setResource('menu');
        $this->assertSame('menu', $stub->getResource());
    }
}

