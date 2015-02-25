<?php

/**
 * @file
 * Contains \Drupal\typed_entity\TypedEntity\TypedEntity.
 */

namespace Drupal\typed_entity\TypedEntity;

class TypedEntity implements TypedEntityInterface {

  /**
   * The entity ID.
   *
   * @var int
   */
  protected $entityId;

  /**
   * The fully loaded entity.
   *
   * @var object
   */
  protected $entity;

  /**
   * The entity type.
   *
   * @var string
   */
  protected $entityType;

  /**
   * The entity bundle.
   *
   * @var string
   */
  protected $bundle;

  /**
   * The EMW
   *
   * @var \EntityDrupalWrapper
   */
  protected $wrapper;

  /**
   * Constructs a TypedEntity object.
   *
   * @param string $entity_type
   *   The type of the entity.
   * @param mixed $entity_id
   *   Either the entity ID or the fully loaded entity.
   */
  public function __construct($entity_type, $entity_id) {
    $this->entityType = $entity_type;

    if (is_numeric($entity_id)) {
      $this->entityId = $entity_id;
      return;
    }
    // The entity was provided.
    $entity = $entity_id;

    list($entity_id,, $bundle) = entity_extract_ids($entity_type, $entity);
    $this->entityId = $entity_id;
    $this->bundle = $bundle;
    $this->entity = $entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getEntityId() {
    return $this->entityId;
  }

  /**
   * {@inheritdoc}
   */
  public function getEntity() {
    if (isset($this->entity)) {
      return $this->entity;
    }
    if (empty($this->getEntityId())) {
      // We do not have neither entity nor ID. We cannot load.
      return NULL;
    }
    $entities = entity_load($this->getEntityType(), array($this->getEntityId()));
    $this->entity = isset($entities[$this->getEntityId()]) ? $entities[$this->getEntityId()] : NULL;
    return $this->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getEntityType() {
    return $this->entityType;
  }

  /**
   * {@inheritdoc}
   */
  public function getBundle() {
    if (isset($this->bundle)) {
      return $this->bundle;
    }

    list(,, $bundle) = entity_extract_ids($this->getEntityType(), $this->getEntity());
    $this->bundle = $bundle;
    return $this->bundle;
  }

  /**
   * {@inheritdoc}
   */
  public function getWrapper() {
    if (isset($this->wrapper)) {
      return $this->wrapper;
    }
    return entity_metadata_wrapper($this->getEntityType(), $this->getEntity());
  }

  /**
   * {@inheritdoc}
   */
  public function save() {
    return $this->getWrapper()->save();
  }

  /**
   * {@inheritdoc}
   */
  public function access($op, $account = NULL) {
    return $this->getWrapper()->access($op, $account);
  }

  /**
   * Implements the magic methods to proxy property access to the entity.
   *
   * @param string $property_name
   *   The name of the property being accessed.
   *
   * @return mixed
   *   The property value.
   */
  public function __get($property_name) {
    return $this->getEntity()->{$property_name};
  }

  /**
   * Implements the magic methods to proxy property access to the entity.
   *
   * @param string $property_name
   *   The name of the property being accessed.
   * @param mixed $value
   *   The property value.
   */
  public function __set($property_name, $value) {
    $this->getEntity()->{$property_name} = $value;
  }

  /**
   * Implements the magic methods to proxy methods to the entity.
   *
   * @param string $name
   *   The method name.
   * @param array $arguments
   *   The arguments.
   *
   * @return mixed
   *   The value returned by the entity method.
   */
  public function __call($name, array $arguments) {
    $callable = array($this->getEntity(), $name);
    if (is_callable($callable)) {
      return call_user_func_array($callable, $arguments);
    }
    return NULL;
  }

}
