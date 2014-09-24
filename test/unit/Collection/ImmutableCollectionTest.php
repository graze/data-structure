<?php
namespace Graze\DataStructure\Collection;

use PHPUnit_Framework_TestCase as TestCase;
use Graze\Sort as s;

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
        $items = array('foo', 'bar', 'baz');
        $coll = new ImmutableCollection($items);

        $this->assertEquals($items, $coll->getAll());
    }

    public function testAdd()
    {
        $coll = new ImmutableCollection(array('foo', 'bar'));
        $result = $coll->add('baz');

        $this->assertEquals(array('foo', 'bar'), $coll->getAll());
        $this->assertEquals(array('foo', 'bar', 'baz'), $result->getAll());
        $this->assertNotSame($coll, $result);
        $this->assertInstanceOf('Graze\DataStructure\Collection\ImmutableCollection', $result);
    }

    public function testAddDuplicate()
    {
        $coll = new ImmutableCollection(array('foo', 'bar', 'baz'));
        $result = $coll->add('baz');

        $this->assertEquals(array('foo', 'bar', 'baz'), $coll->getAll());
        $this->assertEquals(array('foo', 'bar', 'baz', 'baz'), $result->getAll());
        $this->assertNotSame($coll, $result);
        $this->assertInstanceOf('Graze\DataStructure\Collection\ImmutableCollection', $result);
    }

    public function testContainsIsTrue()
    {
        $coll = new ImmutableCollection(array('foo', 'bar', 'baz'));

        $this->assertTrue($coll->contains('foo'));
    }

    public function testContainsIsFalse()
    {
        $coll = new ImmutableCollection(array('FOO', 'bar', 'baz'));

        $this->assertFalse($coll->contains('foo'));
    }

    public function testContainsIsStrict()
    {
        $coll = new ImmutableCollection(array(0, 1));

        $this->assertFalse($coll->contains(false));
    }

    public function testCount()
    {
        $coll = new ImmutableCollection(array('foo', 'bar', 'baz'));

        $this->assertEquals(3, count($coll));
    }

    public function testFilter()
    {
        $coll = new ImmutableCollection(array('foo', 'bar', 'baz'));
        $result = $coll->filter(function ($item) {
            return 'foo' !== $item;
        });

        $this->assertEquals(array('foo', 'bar', 'baz'), $coll->getAll());
        $this->assertEquals(array('bar', 'baz'), $result->getAll());
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
        $coll = new ImmutableCollection(array('foo', 'bar', 'baz'));
        $result = $coll->map(function ($item) {
            return $item[0];
        });

        $this->assertEquals(array('f', 'b', 'b'), $result);
    }

    public function testReduce()
    {
        $coll = new ImmutableCollection(array('foo', 'bar', 'baz'));
        $result = $coll->reduce(function ($carry, $item) {
            return $carry . $item;
        });

        $this->assertEquals('foobarbaz', $result);
    }

    public function testSort()
    {
        $coll = new ImmutableCollection(array(2, 3, 1));
        $result = $coll->sort(s\comparison_fn(function ($item) {
            return $item;
        }));

        $this->assertEquals(array(2, 3, 1), $coll->getAll());
        $this->assertEquals(array(1, 2, 3), $result->getAll());
        $this->assertNotSame($coll, $result);
        $this->assertInstanceOf('Graze\DataStructure\Collection\ImmutableCollection', $result);
    }

    public function testSortOnAsc()
    {
        $coll = new ImmutableCollection(array(2, 3, 1));
        $result = $coll->sortOn(function ($item) {
            return $item;
        });

        $this->assertEquals(array(2, 3, 1), $coll->getAll());
        $this->assertEquals(array(1, 2, 3), $result->getAll());
        $this->assertNotSame($coll, $result);
        $this->assertInstanceOf('Graze\DataStructure\Collection\ImmutableCollection', $result);
    }

    public function testSortOnDesc()
    {
        $coll = new ImmutableCollection(array(2, 3, 1));
        $result = $coll->sortOn(function ($item) {
            return $item;
        }, s\DESC);

        $this->assertEquals(array(2, 3, 1), $coll->getAll());
        $this->assertEquals(array(3, 2, 1), $result->getAll());
        $this->assertNotSame($coll, $result);
        $this->assertInstanceOf('Graze\DataStructure\Collection\ImmutableCollection', $result);
    }

    public function testSerialize()
    {
        $cont = new ImmutableCollection(array('foo', 'bar', 'baz'));

        $this->assertEquals('C:50:"Graze\DataStructure\Collection\ImmutableCollection":48:{a:3:{i:0;s:3:"foo";i:1;s:3:"bar";i:2;s:3:"baz";}}', serialize($cont));
    }

    public function testUnserialize()
    {
        $cont = unserialize('C:50:"Graze\DataStructure\Collection\ImmutableCollection":48:{a:3:{i:0;s:3:"foo";i:1;s:3:"bar";i:2;s:3:"baz";}}');

        $this->assertEquals(array('foo', 'bar', 'baz'), $cont->getAll());
    }
}
