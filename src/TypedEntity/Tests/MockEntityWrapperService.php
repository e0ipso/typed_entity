<?php

/**
 * @file
 * Contains \Drupal\typed_entity\TypedEntity\Tests\MockEntityWrapperService.
 */

namespace Drupal\typed_entity\TypedEntity\Tests;

use Drupal\typed_entity\Entity\EntityWrapperServiceInterface;

class MockEntityWrapperService implements EntityWrapperServiceInterface {

  /**
   * {@inheritdoc}
   */
  public static function wrap($entity_type, $entity) {
    return new MockEntityDrupalWrapper($entity_type, $entity);
  }

}
