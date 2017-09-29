<?php

namespace Graze\DataStructure;

use Graze\DataStructure\Collection\Collection;
use Graze\DataStructure\Collection\CollectionInterface;
use Graze\DataStructure\Collection\ImmutableCollection;
use Graze\DataStructure\Container\Container;
use Graze\DataStructure\Container\ContainerInterface;
use Graze\DataStructure\Container\ImmutableContainer;
use PHPUnit_Framework_TestCase as TestCase;

class FactoryTest extends TestCase
{
    public function testBuildDefaultCollection()
    {
        $array = [
            'a',
            'b',
            'cake',
            'monkey',
        ];

        $factory = new Factory();

        $collection = $factory->build($array);

        $this->assertInstanceOf(CollectionInterface::class, $collection);
        $this->assertInstanceOf(Collection::class, $collection);

        $this->assertTrue($collection->contains('a'));
    }

    public function testBuildDefaultContainer()
    {
        $array = [
            'key'    => 'first',
            'second' => 'data',
            'cake'   => 'poop',
            'no-key',
        ];

        $factory = new Factory();

        $container = $factory->build($array);

        $this->assertInstanceOf(ContainerInterface::class, $container);
        $this->assertInstanceOf(Container::class, $container);

        $this->assertTrue($container->has('key'));
    }

    public function testBuildImmutableCollection()
    {
        $array = [
            'a',
            'b',
            'cake',
            'monkey',
        ];

        $factory = new Factory(ImmutableCollection::class);

        $collection = $factory->build($array);

        $this->assertInstanceOf(CollectionInterface::class, $collection);
        $this->assertInstanceOf(ImmutableCollection::class, $collection);

        $this->assertTrue($collection->contains('a'));
    }

    public function testBuildImmutableContainer()
    {
        $array = [
            'key'    => 'first',
            'second' => 'data',
            'cake'   => 'poop',
            'no-key',
        ];

        $factory = new Factory(Collection::class, ImmutableContainer::class);

        $container = $factory->build($array);

        $this->assertInstanceOf(ContainerInterface::class, $container);
        $this->assertInstanceOf(ImmutableContainer::class, $container);

        $this->assertTrue($container->has('key'));
    }

    public function testRecursiveCollectionBuild()
    {
        $array = [
            'a',
            'b',
            [
                'c',
                'd',
            ],
        ];

        $factory = new Factory();

        $collection = $factory->build($array);

        $this->assertInstanceOf(CollectionInterface::class, $collection);
        $this->assertInstanceOf(Collection::class, $collection);

        $i = 0;
        foreach ($collection as $value) {
            switch ($i++) {
                case 0:
                    $this->assertEquals('a', $value);
                    break;
                case 1:
                    $this->assertEquals('b', $value);
                    break;
                case 2:
                    $this->assertInstanceOf(CollectionInterface::class, $value);
                    $this->assertInstanceOf(Collection::class, $value);
                    break;
            }
        }
    }

    public function testRecursiveContainerBuild()
    {
        $array = [
            'key'    => 'first',
            'second' => 'item',
            'child'  => [
                'thing'  => 'cake',
                'monkey' => 'tree',
            ],
        ];

        $factory = new Factory();

        $container = $factory->build($array);

        $this->assertInstanceOf(ContainerInterface::class, $container);
        $this->assertInstanceOf(Container::class, $container);

        $this->assertTrue($container->has('key'));
        $this->assertTrue($container->has('child'));
        $this->assertInstanceOf(Container::class, $container->get('child'));
        $this->assertTrue($container->get('child')->has('thing'));
        $this->assertEquals('tree', $container->get('child')->get('monkey'));
    }

    public function testRecursiveMixedBuild()
    {
        $array = [
            'key'    => 'first',
            'second' => 'item',
            'list'   => [
                'a',
                'b',
                [
                    'key' => 'third',
                ],
            ],
        ];

        $factory = new Factory();

        $container = $factory->build($array);

        $this->assertInstanceOf(ContainerInterface::class, $container);
        $this->assertInstanceOf(Container::class, $container);

        $this->assertTrue($container->has('key'));
        $this->assertTrue($container->has('list'));
        $this->assertInstanceOf(Collection::class, $container->get('list'));
        $this->assertTrue($container->get('list')->contains('a'));
        $filtered = $container->get('list')->filter(
            function ($item) {
                return ($item instanceof Container);
            }
        );
        $this->assertCount(1, $filtered);
    }

    public function testRecursiveMixedImmutableBuild()
    {
        $array = [
            'key'    => 'first',
            'second' => 'item',
            'list'   => [
                'a',
                'b',
                [
                    'key' => 'third',
                ],
            ],
        ];

        $factory = new Factory(ImmutableCollection::class, ImmutableContainer::class);

        $container = $factory->build($array);

        $this->assertInstanceOf(ContainerInterface::class, $container);
        $this->assertInstanceOf(ImmutableContainer::class, $container);

        $this->assertTrue($container->has('key'));
        $this->assertTrue($container->has('list'));
        $this->assertInstanceOf(ImmutableCollection::class, $container->get('list'));
        $this->assertTrue($container->get('list')->contains('a'));
        $filtered = $container->get('list')->filter(
            function ($item) {
                return ($item instanceof ImmutableContainer);
            }
        );
        $this->assertCount(1, $filtered);
        $this->assertCount(3, $container->get('list'));
    }
}
