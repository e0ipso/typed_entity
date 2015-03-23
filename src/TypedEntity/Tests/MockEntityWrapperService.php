<?php

/**
 * @file
 * Contains \Drupal\typed_entity\TypedEntity\Tests\MockEntityWrapperService.
 */

namespace Drupal\typed_entity\TypedEntity\Tests;

use Drupal\typed_entity\Exception\TypedEntityException;

class MockEntityWrapperService implements MockEntityWrapperServiceInterface {

  /**
   * Fixture array.
   *
   * @var array
   */
  protected $fixture;

  /**
   * Fixture path.
   *
   * @var string
   */
  protected $fixturePath;

  /**
   * {@inheritdoc}
   */
  public static function wrap($entity_type, $entity) {
    return new MockEntityDrupalWrapper($entity_type, $entity);
  }

  /**
   * {@inheritdoc}
   */
  public function getFixture() {
    if ($this->fixture) {
      return $this->fixture;
    }
    $this->fixture = $this->loadFixture($this->fixturePath);
    return $this->fixture;
  }

  /**
   * {@inheritdoc}
   */
  public function setFixturePath($fixturePath) {
    $this->fixturePath = $fixturePath;
  }

  /**
   * Load a fixture from a file with a serialized entity.
   *
   * @param string $fixture_path
   *   The path to a file containing a serialized fixture.
   *
   * @return array
   *   The loaded fixture.
   *
   * @throws TypedEntityException
   */
  protected function loadFixture($fixture_path) {
    $fixture = NULL;
    if (!file_exists($fixture_path)) {
      throw new TypedEntityException('The provided fixture file does not exist.');
    }

    require $fixture_path;

    if (empty($fixture) || !is_array($fixture)) {
      throw new TypedEntityException('The contents of the fixture is not valid.');
    }
    return $fixture;
  }

}
