<?Php

namespace Lacroix\View\Helper;

use \Main\View\Helper\Navbar;
 
class NavbarMobile extends Navbar {
  private $em;
  private $t;

  public function __construct($sm) {
    parent::__construct($sm);
    $this->em = $sm->getServiceLocator()->get('doctrine.entitymanager.orm_default');
    $this->t = $sm->getServiceLocator()->get('Translator');
  }

  public function items() {
    $links = array();

    foreach ($this->em->getRepository('Lacroix\Entity\Room')->findAll() as $item) {
      $links[] = array('text' => sprintf($this->t->translate('Room %s'), $item->getName()),
                       'url' => $this->view->url('mobile/room', array('room_id' => $item->getId())));      
    };

    $links[] = array('text' => $this->t->translate('All rooms'),
                     'url' => $this->view->url('mobile'));

    $user = $this->auth->getIdentity();
    $links[] = array('text' => $user->getFullName(),
                     'url' => $this->view->url('users/logout'));

    return $links;
  }

  public function __invoke() {
    return $this;
  }
}

?>