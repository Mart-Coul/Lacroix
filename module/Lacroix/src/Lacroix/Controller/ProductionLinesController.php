<?php

namespace Lacroix\Controller;
use \Main\Controller\RestController;

class ProductionLinesController extends RestController {
  protected function getDefaultRepository() {
    return $this->getEntityManager()->getRepository('Lacroix\Entity\ProductionLine');
  }
}
