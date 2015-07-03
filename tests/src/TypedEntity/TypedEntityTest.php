<?php

/**
 * @file
 * Contains \Drupal\typed_entity\Tests\TypedEntity\TypedEntityTest
 */

namespace Drupal\typed_entity\Tests;

require_once __DIR__ . '/../../vendor/mateu-aguilo-bosch/drupal-unit-autoload/autoload.php';

use Drupal\service_container\DependencyInjection\Container;
use Drupal\typed_entity\Exception\TypedEntityException;
use Drupal\typed_entity\ServiceContainer\ServiceProvider\TypedEntityServiceProvider;
use Drupal\typed_entity\System\ArrayCacheController;
use Drupal\typed_entity\TypedEntity\TypedEntity;
use Drupal\typed_entity\TypedEntity\TypedEntityManager;
use Mockery as m;

/**
 * @coversDefaultClass \Drupal\typed_entity\TypedEntity\TypedEntity
 * @group dic
 */
class TypedEntityTest extends \PHPUnit_Framework_TestCase {

  const TEST_ENTITY_ID = 1;

  /**
   * Local typed entity.
   *
   * @var TypedEntity
   */
  protected $typedEntity;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $provider = new TypedEntityServiceProvider();
    $service_container = new Container($provider->getContainerDefinition());
    // EntityManagerInterface
    $mocked_entity_manager = m::mock('\Drupal\typed_entity\Entity\EntityManagerInterface');
    $mocked_entity_manager
      ->shouldReceive('entityExtractIds')
      ->andReturnUsing(function ($entity_type, $entity) {
        $bundle = 'invalid';
        $entity_id = static::TEST_ENTITY_ID;
        if ($entity_type == 'node') {
          $bundle = empty($entity->type) ? 'invalid' : $entity->type;
          $entity_id = empty($entity->nid) ? static::TEST_ENTITY_ID : $entity->nid;
        }
        return [$entity_id, $entity_id, $bundle];
      });
    $service_container->set('entity.manager', $mocked_entity_manager);

    // CacheManagerInterface
    $mocked_cache_manager = m::mock('Drupal\typed_entity\System\CacheManagerInterface');
    $mocked_cache_manager
      ->shouldReceive('getController')
      ->withArgs(['cache_bootstrap'])
      ->andReturn(new ArrayCacheController('cache_bootstrap'));
    $service_container->set('system.cache.manager', $mocked_cache_manager);

    // ModuleHandlerInterface
    $mocked_module_handler = m::mock('Drupal\Core\Extension\ModuleHandlerInterface');
    require_once __DIR__ . '/../../../modules/typed_entity_example/typed_entity_example.module';
    $mocked_module_handler
      ->shouldReceive('invokeAll')
      ->withArgs(['typed_entity_registry_info'])
      ->andReturn(typed_entity_example_typed_entity_registry_info());
    $mocked_module_handler
      ->shouldReceive('getModuleList')
      ->andReturn([
        'typed_entity' => 'typed_entity',
        'typed_entity_example' => 'typed_entity_example',
      ]);

    $service_container->set('module_handler', $mocked_module_handler);
    TypedEntityManager::setServiceContainer($service_container);
  }

  /**
   * Tests that TypedEntity::__construct() works properly.
   *
   * @covers ::__construct()
   *
   * @expectedException \Drupal\typed_entity\Exception\TypedEntityException
   */
  public function test___construct__entity() {
    $reflection_property = new \ReflectionProperty('\Drupal\typed_entity\TypedEntity\TypedEntityManager', 'serviceContainer');
    $reflection_property->setAccessible(TRUE);
    $sc = $reflection_property->getValue();

    new TypedEntity($sc->get('entity.manager'), $sc->get('entity.wrapper'), $sc->get('module_handler'), NULL, 1);
  }

  /**
   * Tests that TypedEntity::__construct() works properly.
   *
   * @covers ::__construct()
   *
   * @expectedException \Drupal\typed_entity\Exception\TypedEntityException
   */
  public function test___construct__id() {
    $reflection_property = new \ReflectionProperty('\Drupal\typed_entity\TypedEntity\TypedEntityManager', 'serviceContainer');
    $reflection_property->setAccessible(TRUE);
    $sc = $reflection_property->getValue();

    new TypedEntity($sc->get('entity.manager'), $sc->get('entity.wrapper'), $sc->get('module_handler'), 'node', NULL);
  }

  /**
   * Tests that TypedEntity::getEntityId() works properly.
   *
   * @covers ::getEntityId()
   */
  public function test_getEntityId() {
    $reflection_property = new \ReflectionProperty('\Drupal\typed_entity\TypedEntity\TypedEntityManager', 'serviceContainer');
    $reflection_property->setAccessible(TRUE);
    $sc = $reflection_property->getValue();

    $article = require __DIR__ . '/../../data/entities/article.php';
    $typed_entity = new TypedEntity($sc->get('entity.manager'), $sc->get('entity.wrapper'), $sc->get('module_handler'), 'node', NULL, $article);
    $this->assertEquals($article->nid, $typed_entity->getEntityId());
  }

  /**
   * Tests that TypedEntity::getEntityId() works properly.
   *
   * @expectedException \Drupal\typed_entity\Exception\TypedEntityException
   *
   * @covers ::getEntityId()
   */
  public function test_getEntityId_noEntity() {
    $reflection_property = new \ReflectionProperty('\Drupal\typed_entity\TypedEntity\TypedEntityManager', 'serviceContainer');
    $reflection_property->setAccessible(TRUE);
    $sc = $reflection_property->getValue();

    new TypedEntity($sc->get('entity.manager'), $sc->get('entity.wrapper'), $sc->get('module_handler'), 'node', NULL, NULL);
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
