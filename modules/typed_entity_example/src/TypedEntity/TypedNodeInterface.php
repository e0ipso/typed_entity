<?php

/**
 * @file
 * Contains \Drupal\typed_entity_example\TypedEntity\TypedNodeInterface.
 */

namespace Drupal\typed_entity_example\TypedEntity;

use Drupal\typed_entity\TypedEntity\TypedEntityInterface;

interface TypedNodeInterface extends TypedEntityInterface {

  /**
   * Gets the author of the node.
   *
   * @return TypedEntityInterface
   *   The fully loaded user object.
   */
  public function getAuthor();

}
