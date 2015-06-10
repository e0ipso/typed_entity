<?php

/**
 * @file
 * Contains Drupal\typed_entity\ServiceContainer\ServiceProvider\TypedEntityServiceProvider.
 */

namespace Drupal\typed_entity\ServiceContainer\ServiceProvider;

use Drupal\service_container\DependencyInjection\ServiceProviderInterface;

class TypedEntityServiceProvider implements ServiceProviderInterface {

  /**
   * {@inheritdoc}
   */
  public function getContainerDefinition() {
    $parameters = $services = array();
    $services['entity.wrapper'] = array(
      'class' => '\Drupal\typed_entity\Entity\EntityWrapperService',
    );
    return array(
      'parameters' => $parameters,
      'services' => $services,
    );
  }

  /**
   * {@inheritdoc}
   */
  public function alterContainerDefinition(&$container_definition) {}

}
