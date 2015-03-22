<?php

/**
 * @file
 * Contains \Drupal\typed_entity\Tests\TypedEntityUnitTestCase
 */

namespace Drupal\typed_entity\Tests;

use Drupal\typed_entity\Exception\TypedEntityException;
use Drupal\typed_entity\TypedEntity\Tests\TypedEntityModules;
use Drupal\typed_entity\TypedEntity\TypedEntity;
use Drupal\typed_entity\TypedEntity\TypedEntityManager;
use Drupal\xautoload\Tests\Example\ExampleModules;
use Drupal\xautoload\Tests\Mock\MockDrupalSystem;
use Drupal\xautoload\Tests\VirtualDrupal\DrupalComponentContainer;

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
    $entity = $this->loadFixture(__DIR__ . '/fixtures/article.inc');
    $manager = TypedEntityManager::create('node', $entity);

  }

  /**
   * Helper function to set up the mocked Drupal instance.
   */
  protected function setUpMockDrupalSystem() {
    // Set up the system with the following modules enabled:
    //   - system
    //   - xautoload
    //   - typed_entity
    //   - typed_entity_example
    $example_modules = new TypedEntityModules();
    $components = new DrupalComponentContainer($example_modules);
    $system = new MockDrupalSystem($components);
    xautoload()->getServiceContainer()->set('system', $system);

    $entity_wrapper = new MockEntityWrapperService();
    xautoload()->getServiceContainer()->set('entity_wrapper', $entity_wrapper);
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
