# DataStructure

**Master build:** [![Master branch build status][travis-master]][travis]

This library implements common data structures in PHP.

It can be installed in whichever way you prefer, but we recommend [Composer][packagist].
```json
{
    "require": {
        "graze/data-structure": "*"
    }
}
```

## Documentation
```php
<?php

use Graze\DataStructure\Collection\Collection;
use Graze\DataStructure\Container\Container;

// Collection
$collection = new Collection(array('foo', 'bar'));
$collection->add('baz');
$collection->contains('baz');
$collection->getAll();
$collection->filter(function ($item) {});
$collection->map(function ($item) {});
$collection->reduce(function ($res, $item) {});
$collection->sort(function ($itemA, $itemB) {});
$collection->sortOn(function ($item) {});

// Container
$container = new Container(array('foo' => 0, 'bar' => 1));
$container->add('baz', 2);
$container->has('baz');
$container->forAll(function ($value, $key) {})
$container->get('baz');
$container->set('bam', 3);
$container->remove('bam');
```

### Immutable structures
```php
<?php

use Graze\DataStructure\Collection\ImmutableCollection;
use Graze\DataStructure\Container\ImmutableContainer;

// Collection
$collection = new ImmutableCollection(array('foo', 'bar'));
$collection = $collection->add('baz');
$collection = $collection->filter(function ($item) {});
$collection = $collection->sort(function ($itemA, $itemB) {});
$collection = $collection->sortOn(function ($item) {});

// Container
$container = new ImmutableContainer(array('foo'=>0, 'bar'=>1));
$container = $container->add('baz', 2);
$container = $container->set('bam', 3);
$container = $container->remove('bam');
```

## Contributing
Contributions are accepted via Pull Request, but passing unit tests must be
included before it will be considered for merge.
```bash
$ composer install
$ vendor/bin/phpunit
```

If you have [Vagrant][vagrant] installed, you can build our dev environment to
assist development. The repository will be mounted in `/srv`.
```bash
$ vagrant up
$ vagrant ssh

Welcome to Ubuntu 12.04 LTS (GNU/Linux 3.2.0-23-generic x86_64)
$ cd /srv
```

### License
The content of this library is released under the **MIT License** by
**Nature Delivered Ltd**.<br/> You can find a copy of this license at
http://www.opensource.org/licenses/mit or in [`LICENSE`][license].

<!-- Links -->
[travis]: https://travis-ci.org/graze/data-structure
[travis-master]: https://travis-ci.org/graze/data-structure.png?branch=master
[packagist]: https://packagist.org/packages/graze/data-structure
[vagrant]: http://vagrantup.com
[license]: LICENSE
