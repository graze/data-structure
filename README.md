# Data Structures #

**Version:** *0.1.0*

This is a library of common data structures, currently implementing Collections and Containers.<br/>
It can be installed in whichever way you prefer, but we recommend Composer.
```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:graze/data-structure.git"
        }
    ],

    "require": {
        "graze/data-structure": "dev-master"
    }
}
```

### Collection ###
```php
<?php
use Graze\DataStructure\Collection\Collection;

$collection = new Collection(array('a', 'b', 'c'));
$collection->add('d');
$collection->contains('a');
$collection->filter(function($value) {
    // Just like array_filter with a closure
});
$collection->map(function($value) {
    // Just like array_map
});
$collection->sort(function($value) {
    // Just like usort
});
```

### Container ###
```php
<?php
use Graze\DataStructure\Container\Container;

$container = new Container(array('a' => 1, 'b' => 2, 'c' => 3));
$container->add('d', 4);
$container->has('a');
$container->get('a');
$container->set('a', 1.1);
$container->remove('a');
```
