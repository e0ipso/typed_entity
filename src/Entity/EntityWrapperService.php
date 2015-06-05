<?php

/**
 * @file
 * Contains \Drupal\typed_entity\Entity\EntityWrapperService.
 */

namespace Drupal\typed_entity\Entity;

class EntityWrapperService implements EntityWrapperServiceInterface {

  /**
   * {@inheritdoc}
   */
  public static function wrap($entity_type, $entity) {
    return new \EntityDrupalWrapper($entity_type, $entity);
  }

}
