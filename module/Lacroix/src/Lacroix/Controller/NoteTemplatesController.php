<?php

namespace Lacroix\Controller;
use \Main\Controller\RestController;

class NoteTemplatesController extends RestController {
  protected function getDefaultRepository() {
    return $this->getEntityManager()->getRepository('Lacroix\Entity\NoteTemplate');
  }
}
