<?php

/**
 * @file
 * Contains Drupal\typed_entity\Entity\EntityManager.
 */

namespace Drupal\typed_entity\Entity;


class EntityManager implements EntityManagerInterface {

  /**
   * {@inheritdoc}
   */
  public function entityLoad($entity_type, $ids = FALSE, $conditions = array(), $reset = FALSE) {
    return entity_load($entity_type, $ids, $conditions, $reset);
  }

  /**
   * {@inheritdoc}
   */
  public function entityExtractIds($entity_type, $entity) {
    return entity_extract_ids($entity_type, $entity);
  }

}
