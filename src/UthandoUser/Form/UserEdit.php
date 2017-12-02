<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Form
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Element\Submit;

/**
 * Class UserEdit
 *
 * @package UthandoUser\Form
 */
class UserEdit extends BaseUser
{
    public function init(): void
    {
        parent::init();

        $this->remove('role')
            ->remove('show-password')
            ->remove('passwd')
            ->remove('passwd-confirm')
            ->remove('dateCreated')
            ->remove('dateModified')
            ->remove('active');

        $this->add([
            'name' => 'submit',
            'type' => Submit::class,
            'options' => [
                'label' => 'Update Profile',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ]
        ]);
    }
}
