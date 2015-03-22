<?php

/**
 * @file
 * Contains \Drupal\typed_entity\TypedEntity\Tests\MockEntityDrupalWrapperInterface.
 */

namespace Drupal\typed_entity\TypedEntity\Tests;

use Drupal\typed_entity\Exception\TypedEntityException;

interface MockEntityDrupalWrapperInterface extends \EntityDrupalWrapperInterface {

  /**
   * Load a fixture from a file with a serialized entity.
   *
   * @param string $fixture_path
   *   The path to the file containing the serialized version of the entity. Or
   *   the object itself.
   *
   * @throws TypedEntityException
   */
  public function loadFixture($fixture_path);

}
