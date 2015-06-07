<?php

/**
 * @file
 * Contains \Drupal\typed_entity_example\Tests\TypedEntityExampleUnitTestCase
 */

namespace Drupal\typed_entity_example\Tests;

use Drupal\typed_entity\TypedEntity\TypedEntityManager;
use Drupal\typed_entity_example\TypedEntity\Tests\TypedNodeArticleUnitTest;

class TypedEntityExampleUnitTestCase extends \DrupalUnitTestCase {

  /**
   * Declare test information.
   *
   * @return array
   *   The information array.
   */
  public static function getInfo() {
    return array(
      'name' => 'Typed entity example (unit)',
      'description' => 'Shows an example of how you can do unit testing of your code.',
      'group' => 'Typed Entity',
    );
  }

  /**
   * Test logging message.
   */
  public function testLoggingMessage() {
    require_once __DIR__ . '/../../../../src/TypedEntity/Tests/TypedNodeArticleUnitTest.php';
    $typed_article = new TypedNodeArticleUnitTest('node', 1, NULL, 'article');
    $this->assertEqual($typed_article->getLoggingMessage(), 'User with id 1. Node with title Foo. Status 1.', 'Logging message is successful.');
  }

  /**
   * Test camelize method.
   */
  public function testCamelize() {
    require_once __DIR__ . '/../../../../../../src/TypedEntity/TypedEntityManager.php';
    $this->assertEqual(TypedEntityManager::camelize('abc_def-ghi'), 'AbcDefGhi');
    $this->assertEqual(TypedEntityManager::camelize('1234'), '1234');
    $this->assertEqual(TypedEntityManager::camelize('1-a>234'), '1A>234');
    $this->assertEqual(TypedEntityManager::camelize(''), '');
  }
}
