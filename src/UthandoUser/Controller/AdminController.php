<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Controller;

use UthandoCommon\Controller\AbstractCrudController;
use UthandoUser\Model\User;

/**
 * Class AdminController
 * @package UthandoUser\Controller
 */
class AdminController extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'lastname'];
    protected $serviceName = 'UthandoUser';
    protected $route = 'admin/user';

    public function resetPasswordAction()
    {
        $userId = $this->params()->fromRoute('id', null);
        $user = $this->getService()->getById($userId);

        if ($user instanceof User) {
            $result = $this->getService()->resetPassword($user);

            if ($result) {
                $this->flashMessenger()->addSuccessMessage('User password has been reset and and email with new password has been sent');
            } else {
                $this->flashMessenger()->addErrorMessage('Could not reset the user password.');
            }
        } else {
            $this->flashMessenger()->addErrorMessage('Could not find the user in the database.');
        }

        return $this->redirect()->toRoute('admin/user/edit', [
            'id' => $userId
        ]);
    }

}
