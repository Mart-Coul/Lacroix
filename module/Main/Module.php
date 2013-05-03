<?php

namespace Main;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\EventManager\EventInterface;
use Zend\EventManager\StaticEventManager;

class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig() {
      return include __DIR__ . '/config/service.config.php';
    }

    public function getViewHelperConfig() {
      return include __DIR__ . '/config/helpers.config.php';
    }

  public function onBootstrap(MvcEvent $e) {
    $eventManager        = $e->getApplication()->getEventManager();
    $moduleRouteListener = new ModuleRouteListener();
    $moduleRouteListener->attach($eventManager);

    $sm = $e->getTarget()->getServiceManager();

    StaticEventManager::getInstance()->attach('Zend\Mvc\Application', 
                                              'dispatch', 
                                              array($sm->get('AuthenticationEventHandler'), 'preDispatch'), 
                                              100);

    $e->getApplication()->getMvcEvent()->getViewModel()->identity = $sm->get('AuthService')->getIdentity();

    $em = $e->getApplication()->getEventManager();
    $em->attach(new View\Strategy\JsonException());
    $em->attach(\Zend\Mvc\MvcEvent::EVENT_DISPATCH, 
                function($e) {
                  $controller = $e->getTarget();
                  if ($controller->default_layout) {
                    $controller->layout($controller->default_layout);
                  };
                });

    $translator = $e->getApplication()->getServiceManager()->get('translator');

    $locale = \Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
    if (file_exists(sprintf('public/i18n/%s.po', $locale))) {
      $translator->setLocale($locale);
    } else {
      $translator->setLocale('fr_FR');
    };
    $translator->setFallbackLocale('fr_FR'); 

    // Translations for the standard validation messages
    $translator = new \Zend\I18n\Translator\Translator();
    $translator->addTranslationFile('phpArray',
                                    sprintf('vendor/zendframework/zendframework/resources/languages/%s/Zend_Validate.php',
                                            substr($locale, 0, 2)));
    \Zend\Validator\AbstractValidator::setDefaultTranslator($translator);
  }
}
