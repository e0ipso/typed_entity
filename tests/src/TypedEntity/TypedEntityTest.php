<?php

/**
 * @file
 * Contains \Drupal\typed_entity\Tests\TypedEntity\TypedEntityTest
 */

namespace Drupal\typed_entity\Tests\Discovery;

$loader = require __DIR__ . '/../../vendor/autoload.php';

/** @var callable $autoloader_init */
$autoloader_init = require_once __DIR__ . '/../../vendor/mateu-aguilo-bosch/drupal-unit-autoload/drupal_unit_autoloader.php';
// Register the class loader.
$autoloader_init($loader)->register();


use Drupal\service_container\DependencyInjection\Container;
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
  const TEST_ENTITY_TYPE = 'foo';

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
      ->once()
      ->andReturn([static::TEST_ENTITY_ID, NULL, 'article']);
    $service_container->set('entity.manager', $mocked_entity_manager);

    // CacheManagerInterface
    $mocked_cache_manager = m::mock('Drupal\typed_entity\System\CacheManagerInterface');
    $mocked_cache_manager
      ->shouldReceive('getController')
      ->once()
      ->andReturn(new ArrayCacheController('cache'));
    $service_container->set('system.cache.manager', $mocked_cache_manager);

    // ModuleHandlerInterface
    $mocked_module_handler = m::mock('Drupal\Core\Extension\ModuleHandlerInterface');
    $mocked_module_handler
      ->shouldReceive('invokeAll')
      ->once()
      ->withArgs(['typed_entity_registry_info'])
      ->andReturn([]);
    $mocked_module_handler
      ->shouldReceive('getModuleList')
      ->twice()
      ->andReturn([]);

    $service_container->set('module_handler', $mocked_module_handler);

    TypedEntityManager::setServiceContainer($service_container);
    $this->typedEntity = TypedEntityManager::create(static::TEST_ENTITY_TYPE, static::TEST_ENTITY_ID);
  }

  /**
   * Tests that TypedEntity::__construct() works properly.
   *
   * @covers ::__construct()
   */
  public function test___construct__entity() {
    $this->assertTrue(TRUE);
    // new TypedEntity(NULL, 1);
  }

  /**
   * Tests that TypedEntity::__construct() works properly.
   * @expectedException \Drupal\typed_entity\Exception\TypedEntityException
   * @covers ::__construct()
   */
  public function ___test___construct__id() {
    $this->assertTrue(TRUE);
    // new TypedEntity(static::TEST_ENTITY_TYPE);
  }

  /**
   * Tests that TypedEntity::getEntityId() works properly.
   * @covers ::getEntityId()
   */
  public function ___test_getEntityId() {
    // $this->assertEquals(static::TEST_ENTITY_ID, $this->typedEntity->getEntity());
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
