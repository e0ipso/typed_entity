<?php

/**
 * @file
 * Contains Drupal\typed_entity\Entity\EntityManagerInterface.
 */

namespace Drupal\typed_entity\Entity;


interface EntityManagerInterface {

  /**
   * Loads a list of entities.
   *
   * @see entity_load().
   */
  public function entityLoad($entity_type, $ids = FALSE, $conditions = array(), $reset = FALSE);

  /**
   * Extracts entity ids.
   *
   * @see entity_extract_ids().
   */
  public function entityExtractIds($entity_type, $entity);
}
