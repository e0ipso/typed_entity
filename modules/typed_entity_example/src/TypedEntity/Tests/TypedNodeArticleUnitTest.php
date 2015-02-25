<?php

/**
 * @file
 * Contains \Drupal\typed_entity_example\TypedEntity\Tests\TypedNodeArticleUnitTest.
 */

namespace Drupal\typed_entity_example\TypedEntity\Tests;

use Drupal\typed_entity_example\TypedEntity\Node\Article;

class TypedNodeArticleUnitTest extends Article {

  /**
   * Overrides TypedNodeArticle::t().
   *
   * Override translation method so it does not require the database.
   */
  protected static function t($string, array $args = array()) {
    return format_string($string, $args);
  }

  /**
   * Overrides TypedNodeArticle::getEntity().
   */
  public function getEntity() {
    $article = array(
      'title' => 'Foo',
      'uid' => 1,
      'status' => 1,
      'nid' => 1,
      'type' => 'article',
      'field_body' => array(
        LANGUAGE_NONE => array(
          array(
            'safe_value' => 'bar',
            'value' => 'bar',
          ),
        ),
      ),
    );
    return (object) $article;
  }

}
