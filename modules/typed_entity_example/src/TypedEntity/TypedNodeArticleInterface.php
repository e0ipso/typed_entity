<?php

/**
 * @file
 * Contains \Drupal\typed_entity_example\TypedEntity\TypedNodeArticleInterface.
 */

namespace Drupal\typed_entity_example\TypedEntity;

use Drupal\typed_entity\TypedEntity\TypedEntityInterface;

interface TypedNodeArticleInterface extends TypedNodeInterface {

  /**
   * Gets the author of the node.
   *
   * @return TypedEntityInterface
   *   The fully loaded user object.
   */
  public function getImage();

}
