[![Build Status](https://travis-ci.org/mateu-aguilo-bosch/typed_entity.svg)](https://travis-ci.org/mateu-aguilo-bosch/typed_entity)

# Typed entity

```
Use typed objects for your Drupal entities.
```

This module provides a simple way to treat you existing entities like typed
objects. This will allow you to have a more maintainable and easier to debug
codebase.

## Scenario

You have modelled your content using Drupal's entities and Field API, but now
you are stuck with `stdClass` and `field_get_items`. You could go further and
use `Entity Metadata Wrapper` to have a more comprehensive entity interaction.
That's fine so far.

Now imagine that you need to have some custom business logic that applies only
to `node > article`. You could create your custom module and have your custom
function:

```php
/**
 * Gets the aspect ratio of the field_image attached to a node article.
 * 
 * @param object $node
 *   The node.
 *
 * @return array
 *   Array with width and height.
 */
 function custom_module_article_image_ratio($node) {
   // Do some computation.
   return array('width' => $width, 'height' => $height);
 }
```

As the project grows this is hard to maintain and can get pretty wild. Imagine
`custom_module_article_related_article_image_ratio`, and the several of
variations –even those that don't relate to image ratio. Gasp!–.

## Proposal

Create a typed entity in your custom module under `src/TypedEntity` and make it implement `TypedEntityInterface`. Basically you just have to follow [the example](modules/typed_entity_example/src/TypedEntity/TypedNode.php).

For our example above we would create [`TypedNodeArticle`](modules/typed_entity_example/src/TypedEntity/TypedNodeArticle.php) and then another class called `TypedFileImage`. `TypedFileImage` would have a method to get the aspect ratio:

```php
<?php

/**
 * @file
 * Contains \Drupal\custom_module\TypedEntity\TypedFileImage.
 */

namespace Drupal\custom_module\TypedEntity;

use Drupal\typed_entity\TypedEntity\TypedEntity;

class TypedFileImage extends TypedEntity implements TypedFileImageInterface {

  /**
   * Gets the aspect ratio for the underlying entity.
   *
   * @return array
   *   The width and height.
   */
  public function getAspectRatio() {
    $file = $this->getEntity();
    // Do some computation on $file.
    return array('width' => $width, 'height' => $height);
  }

}
```

Now you can do things like:

```php
$typed_article = TypedEntityManager::create('node', $node);

// custom_module_article_image_ratio(…)
$ratio = $typed_article
  ->getImage()
  ->getAspectRatio();

// custom_module_article_related_article_image_ratio(…)
$ratio = $typed_article
  ->getRelatedArticle()
  ->getImage()
  ->getAspectRatio();
```

## Usage
To declare your typed entities you just have to create the class following the name convention:

  - Typed\<EntityTypeCamelCase\>\<BundleCamelCase\> (Ex: `TypedNodeArticle`).
  - Typed\<EntityTypeCamelCase\> (Ex: `TypedUser`, `TypedNode`).

That class will be discovered and returned by the factory function in
`TypedEntityManager`. Use:

```php
$typed_entity = TypedEntityManager::create($entity_type, $entity);
```

### Accessing the underlying entity
This module uses the PHP magic methods to allow you to do things like:

```php
$typed_entity = TypedEntityManager::create($entity_type, $entity);

// Access the uuid property on the underlying entity.
print $typed_entity->uuid;

// Set properties on the entity.
$typed_entity->status = NODE_PUBLISHED;

// Execute entity methods.
print $typed_entity->myEntityMethod('arg1', 2);
```

This has the benefit (over doing `$typed_entity->getEntity()->myEntityMethod('arg1', 2)`)
that you can then pass the `$typed_entity` in place of a node to functions that
access the node properties or call custom methods on the entity.

## Benefits
Besides [the benefits of OOP](https://duckduckgo.com/?q=object+oriented+programming+benefits)
you can have more structured Drupal entities with clearer relationships. Stop
passing ($entity_type, $entity) around, an entity should be able to know its own
type and bundle.

Care to add **tests**? You can even have unit testing on your custom business logic
(make sure those computations on the aspect ratio return the expected values).

Check out the [unit test example](modules/typed_entity_example/lib/Drupal/typed_entity_example/Tests/TypedEntityUnitTestCase.php).
