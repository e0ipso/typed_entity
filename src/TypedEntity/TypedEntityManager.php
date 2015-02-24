<?php

/**
 * @file
 * Contains \Drupal\typed_entity\TypedEntity\TypedEntityManager.
 */

namespace Drupal\typed_entity\TypedEntity;

class TypedEntityManager implements TypedEntityManagerInterface {

  /**
   * {@inheritdoc}
   */
  public static function create($entity_type, $entity) {
    $class_names = static::getClassNames($entity_type, $entity);

    foreach ($class_names as $class_name) {
      if (class_exists($class_name)) {
        new $class_name($entity_type, $entity);
      }
    }

    return new TypedEntity($entity_type, $entity);
  }

  /**
   * Helper function to get a class name based on the entity type and bundle.
   *
   * If you want your entity types to be auto loaded then you need to place your
   * class in your custom module, under src/TypedEntity. The class needs to be
   * named Typed<EntityTypeCamelCase> or
   * Typed<EntityTypeCamelCase><BundleCamelCase>. For instance TypedNodeArticle.
   *
   * @param string $entity_type
   *   The type of the entity.
   * @param object $entity
   *   The fully loaded entity.
   *
   * @return array
   *   An array of class name candidates.
   */
  protected static function getClassNames($entity_type, $entity) {
    $names = array();
    $class_name_entity = 'Typed' . static::camelize($entity_type);
    list(,, $bundle) = entity_extract_ids($entity_type, $entity);
    $class_name_bundle = 'Typed' . static::camelize($entity_type) . static::camelize($bundle);
    foreach (module_list() as $module_name) {
      // It is important to add the most specific first.
      $names[] = '\\Drupal\\' . $module_name . '\\TypedEntity\\' . $class_name_bundle;
      $names[] = '\\Drupal\\' . $module_name . '\\TypedEntity\\' . $class_name_entity;
    }
    return $names;
  }

  /**
   * Turns a string into camel case. From search_api_index to SearchApiIndex.
   *
   * @param string $input
   *   The input string.
   *
   * @return string
   *   The camelized string.
   */
  protected static function camelize($input) {
    $input = preg_replace('/-_/', ' ', $input);
    $input = ucwords($input);
    $parts = explode('_', $input);
    return implode('', $parts);
  }

}
