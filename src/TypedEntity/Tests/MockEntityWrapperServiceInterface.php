<?php

/**
 * @file
 * Contains \Drupal\typed_entity\TypedEntity\Tests\EntityWrapperServiceInterface.
 */

namespace Drupal\typed_entity\TypedEntity\Tests;

use Drupal\typed_entity\Entity\EntityWrapperServiceInterface;

interface MockEntityWrapperServiceInterface extends EntityWrapperServiceInterface {

  /**
   * Get the loaded fixture.
   *
   * @return array
   */
  public function getFixture();

  /**
   * Sets the fixture path.
   *
   * @param string $fixturePath
   */
  public function setFixturePath($fixturePath);


}
