<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Form
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Form;

use Zend\Form\Form;

/**
 * Class UserSearch
 *
 * @package UthandoUser\Form
 */
class UserSearch extends Form
{
    public function __construct()
    {
        parent::__construct('Search');

        $this->add([
            'name' => 'user',
            'attributes' => [
                'type' => 'text',
                'placeholder' => 'User:'
            ],
            'options' => [
                'label' => 'User:',
            ],
        ]);

        $this->add([
            'name' => 'eamil',
            'attributes' => [
                'type' => 'email',
                'placeholder' => 'Email:'
            ],
            'options' => [
                'label' => 'Site:',
            ],
        ]);
    }

}
