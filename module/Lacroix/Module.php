<?php

namespace Lacroix;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\EventManager\EventInterface;

class EntityInjector {
  private $sl;
  
  public function __construct($serviceLocator) {
    $this->sl = $serviceLocator;
  }
  
  public function postLoad($eventArgs){
    $entity = $eventArgs->getEntity();

    if ($entity instanceof \Lacroix\Entity\ProductionLine) {
      $entity
        ->setDataEntryRepository($this->sl->get('doctrine.entitymanager.orm_default')->getRepository('Lacroix\Entity\DataEntry'))
        ->setTranslator($this->sl->get('translator'));
      
    };
  }
}

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

  public function onBootstrap(EventInterface $e) {
    $sm = $e->getTarget()->getServiceManager();

    $em = $sm->get('doctrine.entitymanager.orm_default');
    $dem = $em->getEventManager();
    $dem->addEventListener(array( \Doctrine\ORM\Events::postLoad ), 
                           new EntityInjector($sm) );
  }
}
