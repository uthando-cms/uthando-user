<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUser\Event
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoUser\Event;

use UthandoUser\Controller\Plugin\IsAllowed;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;

/**
 * Class MvcListener
 *
 * @package UthandoUser\Event
 */
class MvcListener implements ListenerAggregateInterface
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = [];

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events)
    {
        $events = $events->getSharedManager();
        $this->listeners[] = $events->attach(
            AbstractActionController::class,
            MvcEvent::EVENT_DISPATCH,
            [$this, 'doAuthentication'],
            2
        );
    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    public function doAuthentication(MvcEvent $event)
    {
        if (!$event->getRequest() instanceof Request) {
            return true;
        }

        $application    = $event->getApplication();
        $sm             = $application->getServiceManager();
        $match          = $event->getRouteMatch();
        $controller     = $match->getParam('controller');
        $action         = $match->getParam('action');
        $plugin         = $sm->get('ControllerPluginManager')->get(IsAllowed::class);
        $hasIdentity    = $plugin->getIdentity();

        if (!$plugin->isAllowed($controller, $action)) {

            $router = $event->getRouter();
            $url = $router->assemble([], ['name' => ('guest' === $hasIdentity->getRoleId()) ? 'user' : 'home']);

            $response = $event->getResponse();
            $response->setStatusCode(302);
            //redirect to login route...
            // change with header('location: '.$url); if code below not working
            $response->getHeaders()->addHeaderLine('Location', $url);
            $event->stopPropagation();
            return $response;
        }
        return true;
    }
}