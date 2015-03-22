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
   * Constructs a MockEntityDrupalWrapper.
   *
   * @param string $entity_type
   *   The entity type.
   * @param string $bundle
   *   The bundle.
   * @param string $fixture
   *   The object to set.
   */
  public function __construct($entity_type, $bundle = NULL, $fixture = NULL) {
    $this->entityType = $entity_type;
    $this->bundle = $bundle;
    $this->entity = $fixture;
  }

  /**
   * Load a fixture from a file with a serialized entity.
   *
   * @param string $fixture_path
   *   The path to the file containing the serialized version of the entity. Or
   *   the object itself.
   *
   * @throws TypedEntityException
   */
  public function loadFixture($fixture_path) {
    if (!file_exists($fixture_path)) {
      throw new TypedEntityException('The provided fixture file does not exist.');
    }
    if (!$this->entity = (object) unserialize(file_get_contents($fixture_path))) {
      throw new TypedEntityException('The contents of the fixture is not valid.');
    }
  }

  /**
   * {@inheritdoc}
   */
  public function info() {
    $entity_array = (array) $this->entity;
    return array_keys($entity_array);
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

}
