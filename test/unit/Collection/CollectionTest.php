<?php

namespace Graze\DataStructure\Collection;

use Graze\Sort as s;
use PHPUnit_Framework_TestCase as TestCase;

class CollectionTest extends TestCase
{
    public function testInterface()
    {
        $coll = new Collection();

        $this->assertInstanceOf('Graze\DataStructure\Collection\CollectionInterface', $coll);
        $this->assertInstanceOf('Serializable', $coll);
    }

    public function testConstructor()
    {
        $items = ['foo', 'bar', 'baz'];
        $coll = new Collection($items);

        $this->assertEquals($items, $coll->getAll());
    }

    public function testAdd()
    {
        $coll = new Collection(['foo', 'bar']);
        $result = $coll->add('baz');

        $this->assertEquals(['foo', 'bar', 'baz'], $coll->getAll());
        $this->assertSame($coll, $result);
    }

    public function testAddDuplicate()
    {
        $coll = new Collection(['foo', 'bar', 'baz']);
        $result = $coll->add('baz');

        $this->assertEquals(['foo', 'bar', 'baz', 'baz'], $coll->getAll());
        $this->assertSame($coll, $result);
    }

    public function testContainsIsTrue()
    {
        $coll = new Collection(['foo', 'bar', 'baz']);

        $this->assertTrue($coll->contains('foo'));
    }

    public function testContainsIsFalse()
    {
        $coll = new Collection(['FOO', 'bar', 'baz']);

        $this->assertFalse($coll->contains('foo'));
    }

    public function testContainsIsStrict()
    {
        $coll = new Collection([0, 1]);

        $this->assertFalse($coll->contains(false));
    }

    public function testCount()
    {
        $coll = new Collection(['foo', 'bar', 'baz']);

        $this->assertEquals(3, count($coll));
    }

    public function testFilter()
    {
        $coll = new Collection(['foo', 'bar', 'baz']);
        $result = $coll->filter(function ($item) {
            return 'foo' !== $item;
        });

        $this->assertEquals(['bar', 'baz'], $coll->getAll());
        $this->assertSame($coll, $result);
    }

    public function testGetIterator()
    {
        $coll = new Collection();

        $this->assertInstanceOf('Iterator', $coll->getIterator());
    }

    public function testMap()
    {
        $coll = new Collection(['foo', 'bar', 'baz']);
        $result = $coll->map(function ($item) {
            return $item[0];
        });

        $this->assertEquals(['f', 'b', 'b'], $result);
    }

    public function testReduce()
    {
        $coll = new Collection(['foo', 'bar', 'baz']);
        $result = $coll->reduce(function ($carry, $item) {
            return $carry . $item;
        });

        $this->assertEquals('foobarbaz', $result);
    }

    public function testSort()
    {
        $coll = new Collection([2, 3, 1]);
        $result = $coll->sort(s\comparison_fn(function ($item) {
            return $item;
        }));

        $this->assertEquals([1, 2, 3], $coll->getAll());
        $this->assertSame($coll, $result);
    }

    public function testSortOnAsc()
    {
        $coll = new Collection([2, 3, 1]);
        $result = $coll->sortOn(function ($item) {
            return $item;
        });

        $this->assertEquals([1, 2, 3], $coll->getAll());
        $this->assertSame($coll, $result);
    }

    public function testSortOnDesc()
    {
        $coll = new Collection([2, 3, 1]);
        $result = $coll->sortOn(function ($item) {
            return $item;
        }, s\DESC);

        $this->assertEquals([3, 2, 1], $coll->getAll());
        $this->assertSame($coll, $result);
    }

    public function testSerialize()
    {
        $cont = new Collection(['foo', 'bar', 'baz']);

        $this->assertEquals('C:41:"Graze\DataStructure\Collection\Collection":48:{a:3:{i:0;s:3:"foo";i:1;s:3:"bar";i:2;s:3:"baz";}}', serialize($cont));
    }

    public function testUnserialize()
    {
        $cont = unserialize('C:41:"Graze\DataStructure\Collection\Collection":48:{a:3:{i:0;s:3:"foo";i:1;s:3:"bar";i:2;s:3:"baz";}}');

        $this->assertEquals(['foo', 'bar', 'baz'], $cont->getAll());
    }
}
