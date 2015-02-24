<?php

/**
 * @file
 * Contains \Drupal\typed_entity_example\TypedEntity\TypedNodeArticle.
 */

namespace Drupal\typed_entity_example\TypedEntity;

use Drupal\typed_entity\TypedEntity\TypedEntityInterface;
use Drupal\typed_entity\TypedEntity\TypedEntityManager;

class TypedNodeArticle extends TypedNode implements TypedNodeArticleInterface {

  /**
   * The article image.
   *
   * @var TypedEntityInterface
   */
  protected $image;

  /**
   * {@inheritdoc}
   */
  public function getImage() {
    if (isset($this->image)) {
      return $this->image;
    }
    if (!$items = field_get_items($this->getEntityType(), $this->getEntity(), 'field_image')) {
      return NULL;
    }
    $item = reset($items);
    $file_id = $item['fid'];
    return TypedEntityManager::create('user', entity_load_single('file', $file_id));
  }

}
