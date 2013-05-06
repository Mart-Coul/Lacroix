<?php

namespace Lacroix\Controller;

class ConfigurationController extends LacroixController {
  public function indexAction() {
    return $this->viewWithSidebar($this->getTranslator()->translate('Admin backend'),
                                  array(), 
                                  null,
                                  'lacroix/configuration/index');
  }
}
