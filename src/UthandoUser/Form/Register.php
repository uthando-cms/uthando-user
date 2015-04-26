<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 * 
 * @package   UthandoUser\Form
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoUser\Form;

use UthandoUser\InputFilter\User as UserInputFilter;
use Zend\InputFilter\InputFilterInterface;

/**
 * Class Register
 * @package UthandoUser\Form
 */
class Register extends User
{
    public function init()
    {
        parent::init();

        $this->remove('userId')
            ->remove('role')
            ->remove('dateCreated')
            ->remove('dateModified')
            ->remove('active');
    }

    /**
     * @return null|UserInputFilter|InputFilterInterface
     */
    public function getInputFilter()
    {
        $inputFilter = new UserInputFilter();
        return $inputFilter;
    }
} 