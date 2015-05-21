<?php

/**
 * @file
 * Contains \Drupal\typed_entity_example\TypedEntity\Node\Article.
 */

namespace Drupal\typed_entity_example\TypedEntity\Node;

use Drupal\typed_entity\TypedEntity\TypedEntityInterface;
use Drupal\typed_entity\TypedEntity\TypedEntityManager;
use Drupal\typed_entity_example\TypedEntity\TypedNode;

class Article extends TypedNode implements ArticleInterface {

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
    return TypedEntityManager::create('file', entity_load_single('file', $file_id));
  }

  /**
   * {@inheritdoc}
   */
  public function getLoggingMessage() {
    $node = $this->getEntity();
    return $this::t('User with id @uid. Node with title @title. Status @status.', array(
      '@uid' => $node->uid,
      '@title' => $node->title,
      '@status' => $node->status,
    ));
  }

  /**
   * Wraps the translation function to allow overriding for unit testing.
   *
   * @param $string
   *   A string containing the English string to translate.
   * @param $args
   *   An associative array of replacements to make after translation. Based
   *   on the first character of the key, the value is escaped and/or themed.
   *   See format_string() for details.
   *
   * @return string
   *   The translated string.
   */
  protected static function t($string, array $args = array()) {
    return t($string, $args);
  }
}
