<?php

/**
 * @file
 * Contains \Drupal\typed_entity\Tests\TypedEntity\TypedEntityTest
 */

namespace Drupal\typed_entity\Tests\Discovery;
use Drupal\typed_entity\TypedEntity\TypedEntity;

/**
 * @coversDefaultClass \Drupal\typed_entity\TypedEntity\TypedEntity
 * @group dic
 */
class TypedEntityTest extends \PHPUnit_Framework_TestCase {

  const TEST_ENTITY_ID = 1;
  const TEST_ENTITY_TYPE = 'foo';

  /**
   * Local typed entity.
   *
   * @var TypedEntity
   */
  protected $typedEntity;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->typedEntity = new TypedEntity(static::TEST_ENTITY_TYPE, static::TEST_ENTITY_ID);
  }

  /**
   * Tests that TypedEntity::__construct() works properly.
   * @expectedException Drupal\typed_entity\Exception\TypedEntityException
   * @covers ::__construct()
   */
  public function test___construct__entity() {
    new TypedEntity(NULL, 1);
  }

  /**
   * Tests that TypedEntity::__construct() works properly.
   * @expectedException Drupal\typed_entity\Exception\TypedEntityException
   * @covers ::__construct()
   */
  public function test___construct__id() {
    new TypedEntity(static::TEST_ENTITY_TYPE);
  }

  /**
   * Tests that TypedEntity::getEntityId() works properly.
   * @covers ::getEntityId()
   */
  public function test_getEntityId() {
    $this->assertEquals(static::TEST_ENTITY_ID, $this->typedEntity->getEntity());
  }

}
