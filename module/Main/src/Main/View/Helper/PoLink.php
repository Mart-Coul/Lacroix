<?Php

namespace Main\View\Helper;

use Zend\View\Helper\AbstractHelper;
 
class PoLink extends AbstractHelper {
  public function __invoke() {
    $translator = $this->view->plugin('translate')->getTranslator();

    return $this->view->headLink(array('rel' => 'gettext', 
                                       'type' => 'application/x-po', 
                                       'href' => $this->view->basePath() . '/i18n/' . $translator->getLocale() . '.po'));
  }
}

?>