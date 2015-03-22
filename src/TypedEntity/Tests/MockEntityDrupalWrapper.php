<?php

/**
 * @file
 * Contains \Drupal\typed_entity\TypedEntity\Tests\MockEntityDrupalWrapper.
 */

namespace Drupal\typed_entity\TypedEntity\Tests;

use Drupal\typed_entity\Exception\TypedEntityException;

class MockEntityDrupalWrapper implements MockEntityDrupalWrapperInterface {

  /**
   * Entity type.
   *
   * @var string
   */
  protected $entityType;

  /**
   * Bundle.
   *
   * @var string
   */
  protected $bundle;

  /**
   * Entity object.
   *
   * @var object
   */
  protected $entity;

  /**
   * Entity keys. Like the ones provided by entity_get_info().
   *
   * @var object
   */
  protected $entityKeys;

  /**
   * Constructs a MockEntityDrupalWrapper.
   *
   * @param $type
   *   The type of the passed data.
   * @param $data
   *   Optional. The entity to wrap or its identifier.
   * @param $info
   *   Optional. Used internally to pass info about properties down the tree.
   */
  public function __construct($type, $data = NULL, $info = array()) {
    $this->entityType = $type;
    // When using this class for unit testing, set the fixture class in the
    // service container.
    $fixture_path = xautoload()
      ->getServiceContainer()
      ->get('entity_wrapper_fixture_path');
    if (empty($fixture_path)) {
      throw new TypedEntityException('You need to set the fixture path in the service container to mock an entity.');
    }
    $this->loadFixture($fixture_path);
  }

  /**
   * Load a fixture from a file with a serialized entity.
   *
   * @param string|array $fixture
   *   The fixture array or the path of a file containing a serialized fixture.
   *
   * @throws TypedEntityException
   */
  public function loadFixture($fixture) {
    if (!is_array($fixture)) {
      if (!file_exists($fixture)) {
        throw new TypedEntityException('The provided fixture file does not exist.');
      }
      if (!$fixture = unserialize(file_get_contents($fixture))) {
        throw new TypedEntityException('The contents of the fixture is not valid.');
      }
    }
    $this->initFixture($fixture);
  }

  /**
   * Generates a fixture for easier mocking.
   *
   * This function needs to be run in a context with drupal bootstrap.
   *
   * @param string $entity_type
   *   The entity type.
   * @param mixed $entity
   *   Either a loaded entity or its ID.
   *
   * @return string
   *   The serialized fixture array.
   */
  public static function generateFixture($entity_type, $entity) {
    $wrapper = new \EntityDrupalWrapper($entity_type, $entity);
    $entity_info = entity_get_info($wrapper->type());
    $fixture = array(
      'bundle' => $wrapper->getBundle(),
      'entity keys' => $entity_info['entity keys'],
      'entity' => $wrapper->value(),
    );

    $output = serialize($fixture);
    $output = preg_replace("/[\n\r\t]*/", '', $output);
    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function info() {
    return array(
      'langcode' => $this->entity->{$this->entityKeys['language']},
      'type' => $this->entityType,
      'property defaults' => array(),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function type() {
    return $this->entityType;
  }

  /**
   * {@inheritdoc}
   */
  public function value(array $options = array()) {
    return $this->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function raw() {
    return $this->value();
  }

  /**
   * {@inheritdoc}
   */
  public function set($value) {
    $this->entity = $value;
  }

  /**
   * {@inheritdoc}
   */
  public function validate($value) {
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function optionsList($op = 'edit') {
    FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function label() {
    return 'Label';
  }

  /**
   * {@inheritdoc}
   */
  public function access($op, $account = NULL) {
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function getPropertyInfo($name = NULL) {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  public function &refPropertyInfo() {
    return $this->getPropertyInfo();
  }

  /**
   * {@inheritdoc}
   */
  public function language($langcode = LANGUAGE_NONE) {}

  /**
   * {@inheritdoc}
   */
  public function getPropertyLanguage() {
    return (object) array('language' => LANGUAGE_NONE);
  }

  /**
   * {@inheritdoc}
   */
  public function get($name) {
    return new MockEntityDrupalWrapper(NULL, NULL, $this->entity->{$name});
  }

  /**
   * {@inheritdoc}
   */
  public function getIterator() {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  public function getIdentifier() {
    return 1;
  }

  /**
   * {@inheritdoc}
   */
  public function getBundle() {
    $this->bundle;
  }

  /**
   * {@inheritdoc}
   */
  public function view($view_mode = 'full', $langcode = NULL, $page = NULL) {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  public function entityAccess($op, $account = NULL) {
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function save() {}

  /**
   * {@inheritdoc}
   */
  public function delete() {}

  /**
   * {@inheritdoc}
   */
  public function entityInfo() {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  public function entityKey($name) {
    return 'id';
  }

  /**
   * Sub wrappers.
   *
   * @param $name
   *   The name of the requested property.
   *
   * @return \EntityMetadataWrapperInterface
   *   The wrapper.
   */
  public function __get($name) {
    return $this->get($name);
  }

  /**
   * Takes a fixture and initializes the class properties.
   *
   * @param array $fixture
   */
  protected function initFixture(array $fixture) {
    $this->entityKeys = $fixture['entity keys'];
    $this->entityType = $fixture['type'];
    $this->bundle = $fixture['bundle'];
    $this->entity = $fixture['entity'];
  }

}
