<?php

/**
 * @file
 * Contains \Drupal\typed_entity\Tests\TypedEntityUnitTestCase
 */

namespace Drupal\typed_entity\Tests;

use Drupal\typed_entity\Exception\TypedEntityException;
use Drupal\typed_entity\TypedEntity\TypedEntity;

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

}
