<?php

/**
 * @file
 * Contains \Drupal\typed_entity_example\Tests\TypedEntityExampleUnitTestCase
 */

namespace Drupal\typed_entity_example\Tests;

use Drupal\typed_entity\TypedEntity\Tests\MockEntityWrapperService;
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
    $typed_article = new TypedNodeArticleUnitTest(xautoload()->getServiceContainer(), 'node', 1, NULL, 'article');
    $this->assertEqual($typed_article->getLoggingMessage(), 'User with id 1. Node with title Foo. Status 1.', 'Logging message is successful.');
  }

  /**
   * Test camelize method.
   */
  public function testCamelize() {
    $this->assertEqual(TypedEntityManager::camelize('abc_def-ghi'), 'AbcDefGhi');
    $this->assertEqual(TypedEntityManager::camelize('1234'), '1234');
    $this->assertEqual(TypedEntityManager::camelize('1-a>234'), '1A>234');
    $this->assertEqual(TypedEntityManager::camelize(''), '');
  }

  /**
   * Test factory.
   */
  public function testFactory() {
    $wrapper_service = new MockEntityWrapperService();
    $wrapper_service->setFixturePath(__DIR__ . '/fixtures/article.inc');
    xautoload()
      ->getServiceContainer()
      ->set('entity_wrapper', $wrapper_service);

    // Get the mock entity to be loaded.
    $entity = $wrapper_service->wrap('node', NULL)->value();
    $typed_article = TypedEntityManager::create('node', $entity);
    $reflection_article = new \ReflectionClass($typed_article);
    if ($reflection_article->name == 'Drupal\typed_entity_example\TypedEntity\Node\Article') {
      $this->pass('The hook_typed_entity_registry_info is taking precedence.');
    }
    else {
      $this->fail('The hook_typed_entity_registry_info is not taking precedence.');
    }

    $wrapper_service->setFixturePath(__DIR__ . '/fixtures/page.inc');
    // Get the mock entity to be loaded.
    $entity = $wrapper_service->wrap('node', NULL)->value();
    $typed_page = TypedEntityManager::create('node', $entity);

    $reflection_page = new \ReflectionClass($typed_page);
    if ($reflection_page->name == 'Drupal\typed_entity_example\TypedEntity\TypedNode') {
      $this->pass('The factory is falling back to TypedNode.');
    }
    else {
      $this->fail('The factory is not falling back to TypedNode.');
    }

    // Test the fallback to TypedEntity.
    $wrapper_service->setFixturePath(__DIR__ . '/fixtures/page.inc');
    // Get the mock entity to be loaded.
    $entity = $wrapper_service->wrap('node', NULL)->value();
    $typed_user = TypedEntityManager::create('user', $entity);
    $reflection_user = new \ReflectionClass($typed_user);
    if ($reflection_user->name == 'Drupal\typed_entity\TypedEntity\TypedEntity') {
      $this->pass('The factory is falling back to TypedEntity.');
    }
    else {
      $this->fail('The factory is not falling back to TypedEntity.');
    }
  }

}
