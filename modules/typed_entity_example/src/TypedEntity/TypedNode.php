<?php

/**
 * @file
 * Contains \Drupal\typed_entity_example\TypedEntity\TypedNode.
 */

namespace Drupal\typed_entity_example\TypedEntity;

use Drupal\typed_entity\TypedEntity\TypedEntity;
use Drupal\typed_entity\TypedEntity\TypedEntityInterface;
use Drupal\typed_entity\TypedEntity\TypedEntityManager;

class TypedNode extends TypedEntity implements TypedNodeInterface {

  /**
   * The author of the node.
   *
   * @var TypedEntityInterface
   */
  protected $author;

  /**
   * {@inheritdoc}
   */
  public function getAuthor() {
    if (isset($this->author)) {
      return $this->author;
    }
    // The uid property is accessed on the underlying node via __get.
    return TypedEntityManager::create('user', user_load($this->uid));
  }

}
