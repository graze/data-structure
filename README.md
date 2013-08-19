# Data Structures #

**Version:** *0.1.0*<br/>
**Master build:** [![Master branch build status][travis-master]][travis]</br>
**Develop build:** [![Develop branch build status][travis-develop]][travis]

This library implements common data structures in PHP.</br>
It can be installed in whichever way you prefer, but we recommend [Composer][packagist].
```json
{
    "require": {
        "graze/data-structure": "~0.1.0"
    }
}
```

### Basic usage ###
```php
<?php
use Graze\DataStructure\Collection\Collection;
use Graze\DataStructure\Container\Container;

// Collection
$collection = new Collection(array('foo', 'bar'));
$collection->add('baz');
$collection->contains('baz');
$collection->getAll();
$collection->filter(function($val){});
$collection->map(function($val){});
$collection->reduce(function($val){});
$collection->sort(function($x, $y){});

// Container
$container = new Container(array('foo' => 0, 'bar' => 1));
$container->add('baz', 2);
$container->has('baz');
$container->get('baz');
$container->set('bam', 3);
$container->remove('bam');
```


### Contributing ###
We accept contributions to the source via Pull Request,
but passing unit tests must be included before it will be considered for merge.
```bash
$ make install
$ make tests
```

If you have [Vagrant][vagrant] installed, you can build our dev environment to assist development.
The repository will be mounted in `/srv`.
```bash
$ vagrant up
$ vagrant ssh

Welcome to Ubuntu 12.04 LTS (GNU/Linux 3.2.0-23-generic x86_64)
$ cd /srv
```


### License ###
The content of this library is released under the **MIT License** by **Nature Delivered Ltd**.<br/>
You can find a copy of this license at http://www.opensource.org/licenses/mit or in [`LICENSE`][license]


<!-- Links -->
[travis]: https://travis-ci.org/graze/data-structure
[travis-master]: https://travis-ci.org/graze/data-structure.png?branch=master
[travis-develop]: https://travis-ci.org/graze/data-structure.png?branch=develop
[packagist]: https://packagist.org/packages/graze/data-structure
[vagrant]:   http://vagrantup.com
[license]:   /LICENSE
