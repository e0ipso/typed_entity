<?php

/**
 * @file
 * Contains \Drupal\typed_entity\Tests\TypedEntity\TypedEntityTest
 */

namespace Drupal\typed_entity\Tests;

define('CACHE_PERMANENT', 0);

use Drupal\service_container\DependencyInjection\Container;
use Drupal\typed_entity\ServiceContainer\ServiceProvider\TypedEntityServiceProvider;
use Drupal\typed_entity\System\ArrayCacheController;
use Drupal\typed_entity\TypedEntity\TypedEntityManager;
use Mockery as m;

require_once __DIR__ . '/../../vendor/mateu-aguilo-bosch/drupal-unit-autoload/autoload.php';

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
        if ($entity_type == 'node') {
          $bundle = empty($entity->type) ? 'invalid' : $entity->type;
        }
        return [1, 1, $bundle];
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
   * Tests that ::create() works properly.
   *
   * @covers ::create()
   * @covers ::getClassNameCandidatesBundle()
   * @covers ::getClassNameCandidatesEntity()
   * @covers ::getClassNameCandidates()
   */
  public function test_create() {
    $typed_article = TypedEntityManager::create('node', require __DIR__ . '/../../data/entities/article.php');
    $this->assertInstanceOf('Drupal\typed_entity_example\TypedEntity\Node\Article', $typed_article);
  }

  /**
   * Tests that ::getClass works properly.
   *
   * @dataProvider getClassProvider
   *
   * @covers ::getClass()
   *
   * @covers ::getClassNameCandidatesBundle()
   * @covers ::getClassNameCandidatesEntity()
   */
  public function test_getClass($entity_type, $entity, $expected) {
    $this->assertEquals($expected, TypedEntityManager::getClass($entity_type, $entity));
  }

  /**
   * Data provider for getClass.
   */
  public function getClassProvider() {
    return [
      ['node', require __DIR__ . '/../../data/entities/article.php', '\Drupal\typed_entity_example\TypedEntity\Node\Article'],
      ['node', new \stdClass(), '\Drupal\typed_entity_example\TypedEntity\TypedNode'],
      ['invalid', new \stdClass(), '\Drupal\typed_entity\TypedEntity\TypedEntity'],
    ];
  }

  /**
   * Tests that ::camelize() works properly.
   *
   * @dataProvider camelizeProvider
   *
   * @covers ::camelize()
   */
  public function test_camelize($given, $expected) {
    $this->assertEquals($expected, TypedEntityManager::camelize($given));
  }

  /**
   * Provider for camelize.
   */
  public function camelizeProvider() {
    return [
      ['abc_def-ghi', 'AbcDefGhi'],
      ['1234', '1234'],
      ['1-a>234', '1A>234'],
      ['', ''],
    ];
  }

  /**
   * Tests that ::setServiceContainer() works properly.
   *
   * @covers ::setServiceContainer()
   */
  public function test_setServiceContainer() {
    $mocked_container = m::mock('\Drupal\service_container\DependencyInjection\ContainerInterface');
    TypedEntityManager::setServiceContainer($mocked_container);
    $reflection_property = new \ReflectionProperty('\Drupal\typed_entity\TypedEntity\TypedEntityManager', 'serviceContainer');
    $reflection_property->setAccessible(TRUE);
    $this->assertEquals($mocked_container, $reflection_property->getValue());
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
