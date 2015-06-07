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
   * Test logging message.
   */
  public function testConstructor() {
    require_once __DIR__ . '/../../../../src/TypedEntity/TypedEntity.php';
    require_once __DIR__ . '/../../../../src/Exception/TypedEntityException.php';
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
