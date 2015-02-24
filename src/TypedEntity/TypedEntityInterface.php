<?php

/**
 * @file
 * Contains \Drupal\typed_entity\TypedEntity\TypedEntityInterface.
 */

namespace Drupal\typed_entity\TypedEntity;

interface TypedEntityInterface {

  /**
   * Returns the entity ID.
   *
   * @return int
   *   The ID.
   */
  public function getEntityId();

  /**
   * Lazy loads the entity based on the type and ID.
   *
   * @return object
   *   The fully loaded entity.
   */
  public function getEntity();

  /**
   * Returns the entity type.
   *
   * @return string
   *   The entity type.
   */
  public function getEntityType();

  /**
   * Lazy loads the entity bundle.
   *
   * @return string
   *   The bundle.
   */
  public function getBundle();

  /**
   * Lazy loads the entity metadata wrapper.
   *
   * @return \EntityDrupalWrapper
   *   The wrapper.
   */
  public function getWrapper();

  /**
   * Saves the underlying entity.
   *
   * @return bool
   *   TRUE if the entity was successfully saved.
   *
   * @see \EntityDrupalWrapper::save()
   */
  public function save();

  /**
   * Checks the access to the entity.
   *
   * @param string $op
   *   The operation being performed. One of 'view' or 'edit.
   * @param object $account
   *   The account to check access for.
   *
   * @return bool
   *   TRUE if the account has access to the entity.
   *
   * @see \EntityDrupalWrapper::access()
   */
  public function access($op, $account = NULL);

}
