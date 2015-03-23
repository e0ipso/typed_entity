<?php

/**
 * @file
 * Contains \Drupal\typed_entity\Tests\TypedEntityUnitTestCase
 */

namespace Drupal\typed_entity\Tests;

use Drupal\typed_entity\Exception\TypedEntityException;
use Drupal\typed_entity\TypedEntity\Tests\MockEntityDrupalWrapper;
use Drupal\typed_entity\TypedEntity\Tests\MockEntityWrapperService;
use Drupal\typed_entity\TypedEntity\TypedEntity;
use Drupal\typed_entity\TypedEntity\TypedEntityManager;

class TypedEntityUnitTestCase extends \DrupalUnitTestCase {

  /**
   * Declare test information.
   *
   * @return array
   *   The information array.
   */
  public static function getInfo() {
    return array(
      'name' => 'Typed entity',
      'description' => 'Unit tests for Typed Entity.',
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
  public function testConstructor() {
    try {
      new TypedEntity(NULL, 1);
      $this->fail('Exception was not thrown for missing entity type.');
    }
    catch (TypedEntityException $e) {
      $this->pass('Exception was thrown for missing entity type.');
    }

    try {
      new TypedEntity('foo');
      $this->fail('Exception was not thrown for missing entity and ID.');
    }
    catch (TypedEntityException $e) {
      $this->pass('Exception was thrown for missing entity and ID.');
    }
  }

  /**
   * Test TypedEntityManager.
   */
  public function testTypedEntityManager() {
    // Test the discovery.

    // When creating the EMW the entity in the fixture will be used regardless
    // of the passed in entity.
    $wrapper_service = new MockEntityWrapperService();
    $wrapper_service->setFixturePath(__DIR__ . '/fixtures/article.inc');
    xautoload()
      ->getServiceContainer()
      ->set('entity_wrapper', $wrapper_service);

    // Get the mock entity to be loaded.
    $entity = $wrapper_service->wrap('node', NULL)->value();
    $typed_article = TypedEntityManager::create('node', $entity);
    $this->assertEqual('node', $typed_article->getEntityType());
    $this->assertEqual('article', $typed_article->getBundle());
    $this->assertEqual($entity, $typed_article->getEntity(), 'Correct entity set');
    $this->assertTrue($typed_article->access('edit'));
    $this->assertTrue($typed_article->getWrapper() instanceof MockEntityDrupalWrapper);

    $random_name = $this->randomName();
    $random_value = $this->randomString();
    $typed_article->{$random_name} = $random_value;
    $typed_article->save();
    $entity = $typed_article->getEntity();
    $this->assertEqual($entity->{$random_name}, $random_value);
  }

  /**
   * Loads a serialized object from a file.
   *
   * @param string $path
   *   The location of the fixture file.
   *
   * @return mixed
   *   The unserialized value.
   */
  protected static function loadFixture($path) {
    if (!file_exists($path)) {
      return NULL;
    }
    $contents = file_get_contents($path);
    return unserialize($contents);
  }

}
