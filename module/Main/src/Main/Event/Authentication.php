<?php

namespace Main\Event;

use Zend\Mvc\MvcEvent;
use Zend\Permissions\Acl\Role\GenericRole;
use Zend\Permissions\Acl\Resource\GenericResource;

class Authentication {
  const DEFAULT_ROLE = 'guest';
  const DEFAULT_USER_ROLE = 'user';

  public function preDispatch(MvcEvent $event) {
    $sm = $event->getApplication()->getServiceManager();
    $auth = $sm->get('AuthService');
    $acl = $sm->get('AclService');

    $routeMatch = $event->getRouteMatch();
    $controller = $routeMatch->getParam('controller');
    $action = $routeMatch->getParam('action');

    if (!$acl->hasResource($controller)) {
      $acl->addResource(new GenericResource($controller));
    };

    if (!$auth->hasIdentity()) {
      if ($acl->isAllowed(self::DEFAULT_ROLE, $controller, $action)) {
        return;
      };
    } else {
      if ($auth->getIdentity()->isAllowed($acl, $controller, $action, array(self::DEFAULT_USER_ROLE))) {
        return;
      };
    };

    $event->setError('acl');

    $response = $event->getResponse();
    $response->setStatusCode(302);
    $response->getHeaders()->addHeaders(array('Location' => '/users/login'));
  }
}

?>