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

  public function render() {
    return sprintf('<ul class="nav pull-right">%s</ul>',
                   join('', 
                        $this->render_items()));
  }

  public function render_items() {
    $data = array();
    foreach ($this->items() as $item) {
      $data[] = $this->render_item($item);
    };
    return $data;
  }

  public function render_item($item) {
    if (isset($item['submenu'])) {
      return sprintf('<li class="dropdown">%s<ul class="dropdown-menu" role="menu">%s</ul></li>',
                     $this->render_item_dropdown_link($item),
                     $this->render_item_dropdown($item));
    } else {
      return sprintf('<li>%s</li>',
                     $this->render_item_link($item));
    }
  }

  public function render_item_link($item) {
    return sprintf('<a href="%s">%s</a>',
                   $this->view->escapeHtml($item['url']),
                   $this->view->escapeHtml($item['text']));
  }

  public function render_item_dropdown_link($item) {
    return sprintf('<a id="%s" role="button" class="%s" data-toggle="%s" href="%s">%s</a>',
                   $this->view->escapeHtml($item['dropdown-id']),
                   $this->view->escapeHtml($item['dropdown-class']),
                   $this->view->escapeHtml($item['dropdown-toggle']),
                   $this->view->escapeHtml($item['dropdown-href']),
                   $this->view->escapeHtml($item['text']));
  }

  public function render_item_dropdown($item) {
    return sprintf('<ul class="dropdown-menu" role="menu">%s</ul>',
                   join('', $this->render_items_dropdown_items($item['submenu'])));
  }

  public function render_item_dropdown_items($items) {
    $data = array();
    foreach ($items as $item) {
      $data[] = $this->render_item_dropdown_item($item);
    };
    return $data;
  }

  public function render_item_dropdown_item($item) {
    return sprintf('<li><a href="%s">%s</a></li>',
                   $this->view->escapeHtml($subitem['url']),
                   $this->escapeHtml($subitem['name']));
  }

  public function items() {
    if (!$this->auth->getIdentity()) {
      return array(array('text' => $this->view->translate('Login'),
                         'url' => $this->router->assemble(array('controller' => 'user', 'action' => 'login'),
                                                          array('name' => 'users/login'))));
    };

    $user = $this->auth->getIdentity();

    foreach (array(
                   array('text' => $this->view->translate('Configuration'),
                         'controller' => 'configuration',
                         'action' => 'index',
                         'route' => 'configuration'),
                   array('text' => $this->view->translate('Data entry'),
                         'controller' => 'mobile',
                         'action' => 'index',
                         'route' => 'mobile')
                   ) as $item) {

      if ($user->isAllowed($this->acl, 
                           $item['controller'], 
                           $item['action'])) {
        $links[] = array('text' => $item['text'],
                         'hotkey' => isset($item['hotkey']) ? $item['hotkey'] : null,
                         'dropdown-class' => isset($item['dropdown-class']) ? $item['dropdown-class'] : null,
                         'dropdown-toggle' => isset($item['dropdown-toggle']) ? $item['dropdown-toggle'] : null,
                         'dropdown-href' => isset($item['dropdown-href']) ? $item['dropdown-href'] : null,
                         'dropdown-id' => isset($item['dropdown-id']) ? $item['dropdown-id'] : null,
                         'url' => $this->view->url($item['route'],
                                                   isset($item['url_options']) ? $item['url_options'] : array()),
                         'submenu' => isset($item['submenu']) ? $item['submenu'] : null);
      };
    };

    $links[] = array('text' => $user->getFullName(),
                     'url' => $this->router->assemble(array(),
                                                      array('name' => 'users/logout')));

    return $links;
  }

  public function __invoke() {
    return $this;
  }
}

?>