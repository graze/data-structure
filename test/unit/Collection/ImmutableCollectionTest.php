<?php

namespace Graze\DataStructure\Collection;

use Graze\Sort as s;
use PHPUnit_Framework_TestCase as TestCase;

class ImmutableCollectionTest extends TestCase
{
    public function testInterface()
    {
        $coll = new ImmutableCollection();

        $this->assertInstanceOf('Graze\DataStructure\Collection\CollectionInterface', $coll);
        $this->assertInstanceOf('Serializable', $coll);
    }

    public function testConstructor()
    {
        $items = ['foo', 'bar', 'baz'];
        $coll = new ImmutableCollection($items);

        $this->assertEquals($items, $coll->getAll());
    }

    public function testAdd()
    {
        $coll = new ImmutableCollection(['foo', 'bar']);
        $result = $coll->add('baz');

        $this->assertEquals(['foo', 'bar'], $coll->getAll());
        $this->assertEquals(['foo', 'bar', 'baz'], $result->getAll());
        $this->assertNotSame($coll, $result);
        $this->assertInstanceOf('Graze\DataStructure\Collection\ImmutableCollection', $result);
    }

    public function testAddDuplicate()
    {
        $coll = new ImmutableCollection(['foo', 'bar', 'baz']);
        $result = $coll->add('baz');

        $this->assertEquals(['foo', 'bar', 'baz'], $coll->getAll());
        $this->assertEquals(['foo', 'bar', 'baz', 'baz'], $result->getAll());
        $this->assertNotSame($coll, $result);
        $this->assertInstanceOf('Graze\DataStructure\Collection\ImmutableCollection', $result);
    }

    public function testContainsIsTrue()
    {
        $coll = new ImmutableCollection(['foo', 'bar', 'baz']);

        $this->assertTrue($coll->contains('foo'));
    }

    public function testContainsIsFalse()
    {
        $coll = new ImmutableCollection(['FOO', 'bar', 'baz']);

        $this->assertFalse($coll->contains('foo'));
    }

    public function testContainsIsStrict()
    {
        $coll = new ImmutableCollection([0, 1]);

        $this->assertFalse($coll->contains(false));
    }

    public function testCount()
    {
        $coll = new ImmutableCollection(['foo', 'bar', 'baz']);

        $this->assertEquals(3, count($coll));
    }

    public function testFilter()
    {
        $coll = new ImmutableCollection(['foo', 'bar', 'baz']);
        $result = $coll->filter(function ($item) {
            return 'foo' !== $item;
        });

        $this->assertEquals(['foo', 'bar', 'baz'], $coll->getAll());
        $this->assertEquals(['bar', 'baz'], $result->getAll());
        $this->assertNotSame($coll, $result);
        $this->assertInstanceOf('Graze\DataStructure\Collection\ImmutableCollection', $result);
    }

    public function testGetIterator()
    {
        $coll = new ImmutableCollection();

        $this->assertInstanceOf('Iterator', $coll->getIterator());
    }

    public function testMap()
    {
        $coll = new ImmutableCollection(['foo', 'bar', 'baz']);
        $result = $coll->map(function ($item) {
            return $item[0];
        });

        $this->assertEquals(['f', 'b', 'b'], $result);
    }

    public function testReduce()
    {
        $coll = new ImmutableCollection(['foo', 'bar', 'baz']);
        $result = $coll->reduce(function ($carry, $item) {
            return $carry . $item;
        });

        $this->assertEquals('foobarbaz', $result);
    }

    public function testSort()
    {
        $coll = new ImmutableCollection([2, 3, 1]);
        $result = $coll->sort(s\comparison_fn(function ($item) {
            return $item;
        }));

        $this->assertEquals([2, 3, 1], $coll->getAll());
        $this->assertEquals([1, 2, 3], $result->getAll());
        $this->assertNotSame($coll, $result);
        $this->assertInstanceOf('Graze\DataStructure\Collection\ImmutableCollection', $result);
    }

    public function testSortOnAsc()
    {
        $coll = new ImmutableCollection([2, 3, 1]);
        $result = $coll->sortOn(function ($item) {
            return $item;
        });

        $this->assertEquals([2, 3, 1], $coll->getAll());
        $this->assertEquals([1, 2, 3], $result->getAll());
        $this->assertNotSame($coll, $result);
        $this->assertInstanceOf('Graze\DataStructure\Collection\ImmutableCollection', $result);
    }

    public function testSortOnDesc()
    {
        $coll = new ImmutableCollection([2, 3, 1]);
        $result = $coll->sortOn(function ($item) {
            return $item;
        }, s\DESC);

        $this->assertEquals([2, 3, 1], $coll->getAll());
        $this->assertEquals([3, 2, 1], $result->getAll());
        $this->assertNotSame($coll, $result);
        $this->assertInstanceOf('Graze\DataStructure\Collection\ImmutableCollection', $result);
    }

    public function testSerialize()
    {
        $cont = new ImmutableCollection(['foo', 'bar', 'baz']);

        $this->assertEquals('C:50:"Graze\DataStructure\Collection\ImmutableCollection":48:{a:3:{i:0;s:3:"foo";i:1;s:3:"bar";i:2;s:3:"baz";}}', serialize($cont));
    }

    public function testUnserialize()
    {
        $cont = unserialize('C:50:"Graze\DataStructure\Collection\ImmutableCollection":48:{a:3:{i:0;s:3:"foo";i:1;s:3:"bar";i:2;s:3:"baz";}}');

        $this->assertEquals(['foo', 'bar', 'baz'], $cont->getAll());
    }
}
