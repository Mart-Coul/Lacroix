<?Php

namespace Main\View\Helper;

use Zend\View\Helper\AbstractHelper;
 
class CurrentIdentity extends AbstractHelper {
  private $sm;

  public function __construct($sm) {
    $this->sm = $sm;
    $this->auth = $sm->getServiceLocator()->get('AuthService');
  }
 
  public function __invoke() {
    return $this->auth->getIdentity();
  }
}

?>