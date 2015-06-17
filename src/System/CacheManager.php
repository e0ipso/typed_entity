<?php

/**
 * @file
 * Contains Drupal\typed_entity\System\CacheManager.
 */

namespace Drupal\typed_entity\System;


class CacheManager implements CacheManagerInterface {

  /**
   * {@inheritdoc}
   */
  public static function getController($bin = 'cache') {
    return _cache_get_object($bin);
  }

}
