<?php

/**
 * @file
 * Contains Drupal\typed_entity\System\MemoryCacheController.
 */

namespace Drupal\typed_entity\System;


class ArrayCacheController implements \DrupalCacheInterface {

  /**
   * The cache bin.
   *
   * @var string
   */
  protected $bin;

  /**
   * The array of data.
   *
   * @var array
   */
  protected $data;

  /**
   * Constructs a MemoryCacheController object.
   *
   * @param $bin
   *   The cache bin for which the object is created.
   */
  public function __construct($bin) {
    $this->bin = $bin;
    $this->data = array($bin => array());
  }

  /**
   * {@inheritdoc}
   */
  function get($cid) {
    return isset($this->data[$this->bin][$cid]) ? $this::response(array($this->data[$this->bin][$cid])) : NULL;
  }

  /**
   * {@inheritdoc}
   */
  function getMultiple(&$cids) {
    $output = array();
    foreach ($cids as $index => $cid) {
      if (empty($this->data[$this->bin][$cid])) {
        unset($cids[$index]);
        continue;
      }
      $output[] = $this->data[$this->bin][$cid];
    }
    return empty($output) ? NULL : $this::response($output);
  }

  /**
   * {@inheritdoc}
   */
  function set($cid, $data, $expire = CACHE_PERMANENT) {
    $this->data[$this->bin][$cid] = $data;
  }

  /**
   * {@inheritdoc}
   */
  function clear($cid = NULL, $wildcard = FALSE) {
    // The wildcard is ignored.
    unset($this->data[$this->bin][$cid]);
  }

  /**
   * {@inheritdoc}
   */
  function isEmpty() {
    return empty($this->data[$this->bin]);
  }

  /**
   * Builds the response object based on a list of values.
   *
   * @param mixed $values
   *   The value(s) to return.
   *
   * @return object
   *   The cache object.
   */
  protected static function response($values) {
    return (object) array(
      'data' => $values,
    );
  }

}
