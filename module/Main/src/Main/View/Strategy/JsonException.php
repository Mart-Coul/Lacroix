<?php

namespace Main\View\Strategy;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Http\Response as HttpResponse;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\View\Model\JsonModel;

class JsonException implements ListenerAggregateInterface {
  protected $listeners = array();
  
  public function attach(EventManagerInterface $events){
    $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'prepareExceptionViewModel'), 50);
    $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER_ERROR, array($this, 'prepareExceptionViewModel'), 50);
  }

  public function detach(EventManagerInterface $events) {
    foreach ($this->listeners as $index => $listener) {
      if ($events->detach($listener)) {
        unset($this->listeners[$index]);
      }
    }
  }

  public function prepareExceptionViewModel(MvcEvent $e) {
    // Do nothing if no error in the event
    $error = $e->getError();
    if (empty($error)) {
      return;
    }
    
    // Do nothing if the result is a response object
    $result = $e->getResult();
    if ($result instanceof Response) {
      return;
    }
    
    switch ($error) {
    case Application::ERROR_CONTROLLER_NOT_FOUND:
    case Application::ERROR_CONTROLLER_INVALID:
    case Application::ERROR_ROUTER_NO_MATCH:
      // Specifically not handling these
      return;
      
    case Application::ERROR_EXCEPTION:
    default:
      $accept = $e->getRequest()->getHeaders('Accept');

      if ($accept->hasMediaType('text/html') || 
          !$accept->hasMediaType('application/json')) {
        return;
      };

      $exception = $e->getParam('exception');

      $e->setError(null);

      $response = $e->getResponse();
      if (!$response) {
        $response = new HttpResponse();
        $e->setResponse($response);
      };

      if ($exception instanceof \Main\Exception\Base) {
        $response->setStatusCode(400);
        $e->setResult(new JsonModel(array('error' => array('message' => $exception->getMessage(),
                                                           'exception' => $exception->toResponse()))));
      } else {
        $response->setStatusCode(500);
        $e->setResult(new JsonModel(array('error' => array('message' => $exception->getMessage()))));
      };
    }
  }
}
