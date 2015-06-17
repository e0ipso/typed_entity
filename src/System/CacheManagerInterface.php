<?php

/**
 * @file
 * Contains Drupal\typed_entity\System\CacheManager.
 */

namespace Drupal\typed_entity\System;

interface CacheManagerInterface {

  /**
   * Returns the DrupalCacheInterface object.
   *
   * @param string $bin
   *   The cache bin.
   *
   * @return \DrupalCacheInterface
   *   The cache controller.
   */
  public static function getController($bin = 'cache');

}
