<?php

namespace Lacroix\Controller;
use \Main\Controller\RestController;

class RoomsController extends RestController {
  protected function getDefaultRepository() {
    return $this->getEntityManager()->getRepository('Lacroix\Entity\Room');
  }
}
