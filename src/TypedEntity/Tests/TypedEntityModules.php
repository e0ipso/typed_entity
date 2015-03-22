<?php

/**
 * @file
 * Contains \Drupal\typed_entity\TypedEntity\Tests\TypedEntityModules.
 */

namespace Drupal\typed_entity\TypedEntity\Tests;

use Drupal\xautoload\Tests\Example\AbstractExampleModules;

class TypedEntityModules extends AbstractExampleModules {

  /**
   * @return string[]
   */
  public function getAvailableExtensions() {
    return array_fill_keys(array(
        'system',
        'xautoload',
        'typed_entity',
        'typed_entity_example',
      ), 'module');
  }

  /**
   * @return string[]
   */
  public function getExampleClasses() {
    return array(
      'typed_entity' => array(
        '\\Drupal\\typed_entity\\TypedEntity\\TypedEntity',
        '\\Drupal\\typed_entity\\TypedEntity\\TypedEntityInterface',
        '\\Drupal\\typed_entity\\TypedEntity\\TypedEntityManager',
        '\\Drupal\\typed_entity\\TypedEntity\\TypedEntityManagerInterface',
        '\\Drupal\\typed_entity\\TypedEntity\\Tests\\MockEntityDrupalWrapper',
        '\\Drupal\\typed_entity\\TypedEntity\\Tests\\MockEntityDrupalWrapperInterface',
        '\\Drupal\\typed_entity\\TypedEntity\\Tests\\TypedEntityModules',
        '\\Drupal\\typed_entity\\Tests\\TypedEntityUnitTestCase',
      ),
      'typed_entity_example' => array(
        '\\Drupal\\typed_entity_example\\TypedEntity\\TypedNode',
        '\\Drupal\\typed_entity_example\\TypedEntity\\TypedNodeInterface',
        '\\Drupal\\typed_entity_example\\TypedEntity\\Node\\Article',
        '\\Drupal\\typed_entity_example\\TypedEntity\\Node\\ArticleInterface',
        '\\Drupal\\typed_entity_example\\TypedEntity\\Tests\\TypedNodeArticleUnitTest',
        '\\Drupal\\typed_entity_example\\Tests\\TypedEntityExampleUnitTestCase',
        '\\Drupal\\typed_entity_example\\Tests\\TypedEntityExampleWebTestCase',
      ),
    );
  }

  /**
   * Replicates drupal_parse_info_file(dirname($module->uri) . '/' . $module->name . '.info')
   *
   * @see drupal_parse_info_file()
   *
   * @param string $name
   *
   * @return array
   *   Parsed info file contents.
   */
  public function drupalParseInfoFile($name) {
    $info = array('core' => '7.x');
    if (0 === strpos($name, 'typed_entity_example')) {
      $info['dependencies'][] = 'xautoload';
      $info['dependencies'][] = 'entity';
      $info['dependencies'][] = 'typed_entity';
    }
    elseif (0 === strpos($name, 'typed_entity')) {
      $info['dependencies'][] = 'xautoload';
      $info['dependencies'][] = 'entity';
    }
    return $info;
  }

}
