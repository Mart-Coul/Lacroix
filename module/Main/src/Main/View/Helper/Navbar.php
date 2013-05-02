<?Php

namespace Main\View\Helper;

use Zend\View\Helper\AbstractHelper;
 
class Navbar extends AbstractHelper {
  private $sm;

  public function __construct($sm) {
    $this->sm = $sm;
    $this->auth = $sm->getServiceLocator()->get('AuthService');
    $this->acl = $sm->getServiceLocator()->get('AclService');
    $this->router = $sm->getServiceLocator()->get('router');
  }
 
  public function __invoke() {
    if (!$this->auth->getIdentity()) {
      return array(array('text' => $this->view->translate('Login'),
                         'url' => $this->router->assemble(array('controller' => 'user', 'action' => 'login'),
                                                          array('name' => 'users/login'))));
    };

    $user = $this->auth->getIdentity();

    foreach (array(
                   ) as $item) {

      if ($user->isAllowed($this->acl, 
                           $item['url_params']['controller'], 
                           $item['url_params']['action'])) {
        $links[] = array('text' => $item['text'],
                         'hotkey' => isset($item['hotkey']) ? $item['hotkey'] : null,
                         'dropdown-class' => isset($item['dropdown-class']) ? $item['dropdown-class'] : null,
                         'dropdown-toggle' => isset($item['dropdown-toggle']) ? $item['dropdown-toggle'] : null,
                         'dropdown-href' => isset($item['dropdown-href']) ? $item['dropdown-href'] : null,
                         'dropdown-id' => isset($item['dropdown-id']) ? $item['dropdown-id'] : null,
                         'url' => $this->router->assemble($item['url_params'],
                                                          $item['url_options']),
                         'submenu' => isset($item['submenu']) ? $item['submenu'] : null);
      };
    };

    $links[] = array('text' => $user->getFullName(),
                     'url' => $this->router->assemble(array(),
                                                      array('name' => 'users/logout')));

    return $links;
  }
}

?>