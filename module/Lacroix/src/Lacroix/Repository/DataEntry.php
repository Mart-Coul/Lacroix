<?php

namespace Lacroix\Repository;

use Doctrine\ORM\EntityRepository;

class DataEntry extends EntityRepository {
  public function getLastReadingForLine(\Lacroix\Entity\ProductionLine $line) {
    return $this->_em
      ->createQuery('SELECT e FROM Lacroix\Entity\DataEntry e INNER JOIN e.production_line l WHERE l.id = :line_id ORDER BY e.created_at DESC')
      ->setParameter('line_id', $line->getId())
      ->setMaxResults(1)
      ->getOneOrNullResult();
  }
}