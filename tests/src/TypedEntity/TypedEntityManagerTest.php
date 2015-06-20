<?php

/**
 * @file
 * Contains \Drupal\typed_entity\Tests\TypedEntity\TypedEntityTest
 */

namespace Drupal\typed_entity\Tests;

use Drupal\service_container\DependencyInjection\Container;
use Drupal\typed_entity\ServiceContainer\ServiceProvider\TypedEntityServiceProvider;
use Drupal\typed_entity\System\ArrayCacheController;
use Drupal\typed_entity\TypedEntity\TypedEntityManager;
use Mockery as m;

$loader = require __DIR__ . '/../../vendor/autoload.php';

/** @var callable $autoloader_init */
$autoloader_init = require_once __DIR__ . '/../../vendor/mateu-aguilo-bosch/drupal-unit-autoload/drupal_unit_autoloader.php';
if ($autoloader_init && $autoloader_init !== TRUE) {
  // Register the class loader.
  $autoloader_init($loader)->register();
}

/**
 * Class TypedEntityManagerTest
 *
 * @coversDefaultClass Drupal\typed_entity\TypedEntity\TypedEntityManager
 * @package Drupal\typed_entity\Tests
 */
class TypedEntityManagerTest extends \PHPUnit_Framework_TestCase {

  const TEST_ENTITY_ID = 1;
  const TEST_ENTITY_TYPE = 'node';

  /**
   * Tests that ::create() works properly.
   *
   * @covers ::create()
   * @covers ::getClassNameCandidatesBundle()
   * @covers ::getClassNameCandidatesEntity()
   * @covers ::getClassNameCandidates()
   */
  public function test_create() {
    $provider = new TypedEntityServiceProvider();
    $service_container = new Container($provider->getContainerDefinition());
    // EntityManagerInterface
    $mocked_entity_manager = m::mock('\Drupal\typed_entity\Entity\EntityManagerInterface');
    $mocked_entity_manager
      ->shouldReceive('entityExtractIds')
      ->once()
      ->andReturn([static::TEST_ENTITY_ID, NULL, 'article']);
    $service_container->set('entity.manager', $mocked_entity_manager);

    // CacheManagerInterface
    $mocked_cache_manager = m::mock('Drupal\typed_entity\System\CacheManagerInterface');
    $mocked_cache_manager
      ->shouldReceive('getController')
      ->once()
      ->withArgs(['cache_bootstrap'])
      ->andReturn(new ArrayCacheController('cache_bootstrap'));
    $service_container->set('system.cache.manager', $mocked_cache_manager);

    // ModuleHandlerInterface
    $mocked_module_handler = m::mock('Drupal\Core\Extension\ModuleHandlerInterface');
    require_once __DIR__ . '/../../../modules/typed_entity_example/typed_entity_example.module';
    $mocked_module_handler
      ->shouldReceive('invokeAll')
      ->once()
      ->withArgs(['typed_entity_registry_info'])
      ->andReturn(typed_entity_example_typed_entity_registry_info());
    $mocked_module_handler
      ->shouldReceive('getModuleList')
      ->twice()
      ->andReturn([
        'typed_entity' => 'typed_entity',
        'typed_entity_example' => 'typed_entity_example',
      ]);

    $service_container->set('module_handler', $mocked_module_handler);

    TypedEntityManager::setServiceContainer($service_container);
    $this->typedEntity = TypedEntityManager::create(static::TEST_ENTITY_TYPE, require __DIR__ . '/../../data/entities/article.php');
    $this->assertInstanceOf('Drupal\typed_entity_example\TypedEntity\Node\Article', $this->typedEntity);
  }

  /**
   * Returns a container definition used for testing.
   *
   * @return array
   *   The container definition with services and parameters.
   */
  protected function getContainerDefinition() {
    $parameters = $services = array();

    // Mock the services.
    $mocked_entity_manager = m::mock('Drupal\typed_entity\Entity\EntityManagerInterface');
    $mocked_entity_metadata_service = m::mock('Drupal\typed_entity\Entity\EntityWrapperServiceInterface');
    $mocked_cache_manager = m::mock('Drupal\typed_entity\System\CacheManagerInterface');
    $mocked_module_handler = m::mock('Drupal\Core\Extension\ModuleHandlerInterface');

    $services['entity.manager'] = array('class' => get_class($mocked_entity_manager));
    $services['entity.wrapper'] = array('class' => get_class($mocked_entity_metadata_service));
    $services['system.cache.manager'] = array('class' => get_class($mocked_cache_manager));
    $services['module_handler'] = array('class' => get_class($mocked_module_handler));
    return array(
      'services' => $services,
      'parameters' => $parameters,
    );
  }

}
