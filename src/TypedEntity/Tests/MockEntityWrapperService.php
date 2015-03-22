<?php

/**
 * @file
 * Contains \Drupal\typed_entity\Entity\MockEntityWrapperService.
 */

namespace Drupal\typed_entity\Entity;

use Drupal\typed_entity\TypedEntity\Tests\MockEntityDrupalWrapper;

class MockEntityWrapperService implements EntityWrapperServiceInterface {

  /**
   * {@inheritdoc}
   */
  public static function wrap($entity_type, $entity) {
    return new MockEntityDrupalWrapper($entity_type, $entity);
  }

}
