<?php

/**
 * @file
 * Contains \Drupal\typed_entity\TypedEntity\TypedEntityManagerInterface.
 */

namespace Drupal\typed_entity\TypedEntity;

use Drupal\service_container\DependencyInjection\ContainerInterface;

interface TypedEntityManagerInterface {

  /**
   * Factory method to guess the typed entity and default to TypedEntity.
   *
   * @param string $entity_type
   *   The type of the entity.
   * @param object $entity
   *   The fully loaded entity.
   *
   * @return TypedEntityInterface
   *   The typed entity.
   */
  public static function create($entity_type, $entity);

  /**
   * Turns a string into camel case. From search_api_index to SearchApiIndex.
   *
   * @param string $input
   *   The input string.
   *
   * @return string
   *   The camelized string.
   */
  public static function camelize($input);

  /**
   * Sets the service container.
   *
   * @param ContainerInterface $service_container
   *   The container to set for the TypedEntityManager.
   */
  public static function setServiceContainer(ContainerInterface $service_container);

}
