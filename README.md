# graze/data-structure

[![Build status][ico-build]][travis]
[![Code Quality][ico-quality]][scrutinizer]
[![Latest Version][ico-package]][packagist]
[![PHP ~5.3][ico-engine]][lang]
[![MIT Licensed][ico-license]][license]
[![Style CI][ico-style]][styleci]

<!-- Links -->
[travis]: https://travis-ci.org/graze/data-structure
[packagist]: https://packagist.org/packages/graze/data-structure
[lang]: https://secure.php.net
[license]: https://github.com/graze/data-structure/blob/master/LICENSE
[scrutinizer]: https://scrutinizer-ci.com/g/graze/data-structure/
[styleci]: https://styleci.io/repos/11204162

<!-- Images -->
[ico-build]: https://img.shields.io/travis/graze/data-structure.svg?style=flat-square
[ico-package]: https://img.shields.io/packagist/v/graze/data-structure.svg?style=flat-square
[ico-engine]: https://img.shields.io/badge/php-%3E%3D5.5-8892BF.svg?style=flat-square
[ico-license]: https://img.shields.io/packagist/l/graze/data-structure.svg?style=flat-square
[ico-quality]: https://img.shields.io/scrutinizer/g/graze/data-structure.svg?style=flat-square
[ico-style]: https://styleci.io/repos/11204162/shield

This library implements common data collections and containers in PHP.

## Install

It can be installed in whichever way you prefer, but we recommend [Composer][packagist].

``` bash
$ composer require graze/data-structure
```

## Usage
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

// Immutable collection
$collection = new ImmutableCollection(array('foo', 'bar'));
$collection = $collection->add('baz');
$collection = $collection->filter(function ($item) {});
$collection = $collection->sort(function ($itemA, $itemB) {});
$collection = $collection->sortOn(function ($item) {});

// Immutable container
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
[vagrant]: http://vagrantup.com
