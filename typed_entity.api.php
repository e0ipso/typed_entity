<?php

/**
 * @file
 * Hook documentation file.
 */

/**
 * Returns an array with the mappings of the entity type, bundle and classes.
 *
 * Use this as an alternative to the naming convention.
 *
 * @return array
 *   The array of items.
 */
function hook_typed_entity_registry_info() {
  $items['user'] = array(
    'entity_type' => 'user',
    'class' => '\Drupal\custom_module\Foo\Bar\User',
  );
  $items['file'] = array(
    'entity_type' => 'file',
    'bundle' => 'image',
    'class' => '\Drupal\custom_module\File\Image',
  );

  return $items;
}
