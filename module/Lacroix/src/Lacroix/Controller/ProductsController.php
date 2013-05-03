<?php

namespace Lacroix\Controller;
use \Main\Controller\RestController;

class ProductsController extends RestController {
  protected function getDefaultRepository() {
    return $this->getEntityManager()->getRepository('Lacroix\Entity\Product');
  }
}
