<?php
namespace Graze\DataStructure\Collection;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->items = array('foo', 'bar');
        $this->collection = new Collection($this->items);
    }

    public function testCollectionInterface()
    {
        $this->assertInstanceOf('Graze\\DataStructure\\Collection\\CollectionInterface', $this->collection);
    }

    public function testSerializableInterface()
    {
        $this->assertInstanceOf('Serializable', $this->collection);
    }

    public function testAdd()
    {
        $this->collection->add('baz'); 
        $this->assertTrue($this->collection->contains('baz'));
    }

    public function testContains()
    {
        $this->assertTrue($this->collection->contains('foo'));
    }

    public function testContainsMissingReturnsFalse()
    {
        $this->assertFalse($this->collection->contains('baz'));
    }

    public function testCount()
    {
        $this->assertCount(count($this->items), $this->collection);
    }

    public function testFilter()
    {
        $filtered = $this->collection->filter(function($value) {
            return 'foo' !== $value;
        });

        $this->assertSame($filtered, $this->collection->getAll());
        $this->assertFalse($this->collection->contains('foo'));
    }

    public function testGetAll()
    {
        $this->assertSame($this->items, $this->collection->getAll());
    }

    public function testMap()
    {
        $this->assertSame(array('f', 'b'), $this->collection->map(function($value) {
            return $value[0];
        }));

        $this->assertSame($this->items, $this->collection->getAll());
    }

    public function testReduce()
    {
        $this->assertSame('foobar', $this->collection->reduce(function($result, $value) {
            $result .= $value;
            return $result;
        }));

        $this->assertSame($this->items, $this->collection->getAll());
    }

    public function testReduceWithInitialValue()
    {
        $this->assertSame('_foobar', $this->collection->reduce(function($result, $value) {
            $result .= $value;
            return $result;
        }, '_'));

        $this->assertSame($this->items, $this->collection->getAll());
    }

    public function testSort()
    {
        $sorted = $this->collection->sort(function($a, $b) {
            return $a > $b ? 1 : -1;
        });

        $this->assertSame(array('bar', 'foo'), $sorted);
        $this->assertSame($sorted, $this->collection->getAll());
    }

    public function testGetIterator()
    {
        $this->assertInstanceOf('Iterator', $this->collection->getIterator());
    }

    public function testSerialize()
    {
        $this->assertSame(serialize($this->items), $this->collection->serialize());
    }

    public function testUnserialize()
    {
        $collection = new Collection();
        $collection->unserialize(serialize($this->items));

        $this->assertSame($this->items, $collection->getAll());
    }
}
