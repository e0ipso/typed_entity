<?php

/**
 * @file
 * Contains \Drupal\typed_entity_example\TypedEntity\Node\ArticleInterface.
 */

namespace Drupal\typed_entity_example\TypedEntity\Node;

use Drupal\typed_entity\TypedEntity\TypedEntityInterface;
use Drupal\typed_entity_example\TypedEntity\TypedNodeInterface;

interface ArticleInterface extends TypedNodeInterface {

  /**
   * Gets the image of the node.
   *
   * @return TypedEntityInterface
   *   The fully loaded image object.
   */
  public function getImage();

  /**
   * Generates a message suited for logging.
   *
   * @return string
   *   The message.
   */
  public function getLoggingMessage();

}
