<?php

/**
 * @file
 * Contains \Drupal\typed_entity\Entity\EntityWrapperServiceInterface.
 */

namespace Drupal\typed_entity\Entity;

interface EntityWrapperServiceInterface {

  /**
   * Wraps an entity based on its type.
   *
   * @param string $entity_type
   *   The entity type.
   * @param mixed $entity
   *   The loaded entity or entity ID.
   *
   * @return \EntityDrupalWrapperInterface
   */
  public static function wrap($entity_type, $entity);

}
