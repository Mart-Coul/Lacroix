<?php

namespace Lacroix\Controller;

class ConfigurationController extends LacroixController {
  public function indexAction() {
    return $this->viewWithSidebar($this->getTranslator()->translate('Configuration'),
                                  array(), 
                                  null,
                                  'lacroix/configuration/index');
  }
}
