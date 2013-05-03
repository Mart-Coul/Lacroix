<?php

namespace Lacroix\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="note_templates")
 */
class NoteTemplate {
  /**
   * @ORM\Id
   * @ORM\Column(type="integer");
   * @ORM\GeneratedValue(strategy="AUTO");
   */
  protected $id;

  /**
   * @ORM\Column(type="string")
   */
  protected $content;

  /*
   * Misc getters / setters
   */

  public function getId() {
    return $this->id;
  }

  public function getContent() {
    return $this->content;
  }

  public function setContent($value) {
    $this->content = $value;
    return $this;
  }
}