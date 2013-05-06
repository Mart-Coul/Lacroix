<?php

namespace Lacroix\Controller;
use \Main\Controller\RestController;
use \Zend\View\Model\ViewModel;

abstract class LacroixController extends RestController {
  protected function viewWithSidebar($title, $content, $current, $template) {
    $sidebar = new ViewModel(array('current' => $current));
    $sidebar->setTemplate('elements/sidebar');

    $view = new ViewModel(array('title' => $title));
    $view->setTemplate('elements/view-with-sidebar');

    $content = new ViewModel($content);
    $content->setTemplate($template);

    $view
      ->addChild($content, 'content')
      ->addChild($sidebar, 'sidebar');

    return $view;
  }

  protected function getDefaultRepository() {
    return null;
  }

  protected function getNewForm() {
    return null;
  }

  protected function getEditForm($item) {
    return null;
  }

  protected function getDeleteForm($item) {
    return null;
  }
}
