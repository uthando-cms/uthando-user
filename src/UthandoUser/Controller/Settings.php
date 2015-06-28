<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace UthandoUser\Controller;

use UthandoCommon\Controller\ServiceTrait;
use Zend\Config\Writer\PhpArray;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class Settings
 *
 * @package UthandoUser\Controller
 */
class Settings extends AbstractActionController
{
    use ServiceTrait;

    public function indexAction()
    {
        $form = $this->getServiceLocator()
            ->get('FormElementManager')
            ->get('UthandoUserSettings');

        $prg = $this->prg();

        $config = $this->getServiceLocator()->get('config');
        $settings = $config['uthando_user'];

        if ($prg instanceof Response) {
            return $prg;
        } elseif (false === $prg) {
            $form->setData($settings);
            return ['form' => $form,];
        }

        $form->setData($prg);

        if ($form->isValid()) {
            $array = $form->getData();
            unset($array['button-submit']);

            $config = new PhpArray();
            $config->toFile('./config/autoload/user.local.php', ['uthando_user' => $array]);

            $this->flashMessenger()->addSuccessMessage('Settings have been updated!');
        }

        return ['form' => $form,];
    }
}