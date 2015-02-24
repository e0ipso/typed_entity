<?php

/**
 * @file
 * Contains \Drupal\typed_entity\TypedEntity\TypedEntityManagerInterface.
 */

namespace Drupal\typed_entity\TypedEntity;

interface TypedEntityManagerInterface {

  /**
   * Factory method to guess the typed entity and default to TypedEntity.
   *
   * @param string $entity_type
   *   The type of the entity.
   * @param object $entity
   *   The fully loaded entity.
   *
   * @return TypedEntityInterface
   *   The typed entity.
   */
  public static function create($entity_type, $entity);

}
