<?php

/**
 * @file
 * Contains \Drupal\typed_entity_example\Tests\TypedEntityUnitTestCase
 */

namespace Drupal\typed_entity_example\Tests;

class TypedEntityUnitTestCase extends \DrupalUnitTestCase {

  /**
   * Declare test information.
   *
   * @return array
   *   The information array.
   */
  public static function getInfo() {
    return array(
      'name' => 'Plug display name',
      'description' => 'Test the display name method functionality.',
      'group' => 'Plug',
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

    // Get a new Name plugin manager to instantiate the test plugins.
    $this->manager = NamePluginManager::create();
  }



}
