<?php

/**
 * @file
 * Contains \Drupal\typed_entity_example\Tests\TypedEntityExampleUnitTestCase
 */

namespace Drupal\typed_entity_example\Tests;

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
      'name' => 'Typed entity example',
      'description' => 'Shows an example of how you can do unit testing of your code.',
      'group' => 'Typed Entity',
    );
  }

  /**
   * Set up.
   */
  public function setUp() {
    // Let xautoload to discover where classes live. We cannot rely on Drupal's
    // autoloader since the database will not be ready at this point for unit
    // tests.
    spl_autoload_unregister('drupal_autoload_class');
    spl_autoload_unregister('drupal_autoload_interface');

    parent::setUp();
  }

  /**
   * Test logging message.
   */
  public function testLoggingMessage() {
    $typed_article = new TypedNodeArticleUnitTest('node', 1, NULL, 'article');
    $this->assertEqual($typed_article->getLoggingMessage(), 'User with id 1. Node with title Foo. Status 1.', 'Logging message is successful.');
  }

}
