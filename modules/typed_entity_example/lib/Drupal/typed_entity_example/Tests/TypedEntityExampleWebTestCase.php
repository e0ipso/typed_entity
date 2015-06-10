<?php

/**
 * @file
 * Contains \Drupal\typed_entity_example\Tests\TypedEntityExampleWebTestCase
 */

namespace Drupal\typed_entity_example\Tests;

use Drupal\typed_entity\TypedEntity\TypedEntity;
use Drupal\typed_entity\TypedEntity\TypedEntityManager;
use Drupal\typed_entity_example\TypedEntity\Node\Article;
use Drupal\typed_entity_example\TypedEntity\TypedNode;

class TypedEntityExampleWebTestCase extends \DrupalWebTestCase {

  /**
   * Declare test information.
   *
   * @return array
   *   The information array.
   */
  public static function getInfo() {
    return array(
      'name' => 'Typed entity example (functional)',
      'description' => 'Functional tests for Typed Entity.',
      'group' => 'Typed Entity',
    );
  }

  /**
   * Set up.
   */
  protected function setUp() {
    parent::setUp('typed_entity_example');
  }

  /**
   * Test factory.
   */
  public function testFactory() {
    $article = $this->drupalCreateNode(array(
      'type' => 'article',
      'title' => 'Test article',
    ));
    $typed_article = TypedEntityManager::create('node', $article);
    $reflection_article = new \ReflectionClass($typed_article);
    if ($reflection_article->name == 'Drupal\typed_entity_example\TypedEntity\Node\Article') {
      $this->pass('The hook_typed_entity_registry_info is taking precedence.');
    }
    else {
      $this->fail('The hook_typed_entity_registry_info is not taking precedence.');
    }

    // Test the fallback to the TypedNode.
    $page = $this->drupalCreateNode(array(
      'type' => 'page',
      'title' => 'Test article',
    ));
    $typed_page = TypedEntityManager::create('node', $page);

    $reflection_page = new \ReflectionClass($typed_page);
    if ($reflection_page->name == 'Drupal\typed_entity_example\TypedEntity\TypedNode') {
      $this->pass('The factory is falling back to TypedNode.');
    }
    else {
      $this->fail('The factory is not falling back to TypedNode.');
    }

    // Test the fallback to TypedEntity.
    $account = $this->drupalCreateUser();
    $typed_user = TypedEntityManager::create('user', $account);
    $reflection_user = new \ReflectionClass($typed_user);
    if ($reflection_user->name == 'Drupal\typed_entity\TypedEntity\TypedEntity') {
      $this->pass('The factory is falling back to TypedEntity.');
    }
    else {
      $this->fail('The factory is not falling back to TypedEntity.');
    }
  }

  /**
   * Test the service container integration.
   */
  public function testServiceContainer() {
    $article = $this->drupalCreateNode(array(
      'type' => 'article',
      'title' => 'Test article',
    ));
    $typed_article = TypedEntityManager::create('node', $article);
    $wrapper = $typed_article->getWrapper();
    $this->assertTrue($wrapper instanceof \EntityDrupalWrapperInterface);
  }

}
