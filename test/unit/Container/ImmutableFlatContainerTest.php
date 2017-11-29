<?php

namespace Graze\DataStructure\Container;

use PHPUnit_Framework_TestCase as TestCase;

class ImmutableFlatContainerTest extends TestCase
{
    public function testInterface()
    {
        $cont = new ImmutableFlatContainer();

        $this->assertInstanceOf('Graze\DataStructure\Container\ContainerInterface', $cont);
        $this->assertInstanceOf('Serializable', $cont);
    }

    public function testConstructor()
    {
        $params = ['foo' => 'a', 'bar' => 'b', 'baz' => 'c'];
        $cont = new ImmutableFlatContainer($params);

        $this->assertEquals($params, $cont->getAll());
    }

    public function testAdd()
    {
        $cont = new ImmutableFlatContainer(['foo' => 'a', 'bar' => 'b']);
        $result = $cont->add('baz', 'c');

        $this->assertEquals(['foo' => 'a', 'bar' => 'b'], $cont->getAll());
        $this->assertEquals(['foo' => 'a', 'bar' => 'b', 'baz' => 'c'], $result->getAll());
        $this->assertNotSame($cont, $result);
        $this->assertInstanceOf(ImmutableFlatContainer::class, $result);
    }

    /**
     * @expectedException \Graze\DataStructure\Exception\RegisteredKeyException
     */
    public function testAddDuplicate()
    {
        $cont = new ImmutableFlatContainer(['foo' => 'a', 'bar' => 'b', 'baz' => 'c']);

        $cont->add('baz', 'd');
    }

    public function testForAll()
    {
        $params = ['foo' => 'a', 'bar' => 'b', 'baz' => 'c'];
        $seen = [];

        $cont = new ImmutableFlatContainer($params);
        $cont->forAll(function ($value, $key) use (&$seen) {
            $seen[$key] = $value;
        });

        $this->assertEquals($params, $seen);
    }

    public function testGet()
    {
        $cont = new ImmutableFlatContainer(['foo' => ['child' => 'a'], 'bar' => 'b', 'baz' => 'c']);

        $this->assertEquals('a', $cont->get('foo.child'));
    }

    public function testGetMissing()
    {
        $cont = new ImmutableFlatContainer();

        $this->assertNull($cont->get('foo'));
    }

    public function testGetIterator()
    {
        $cont = new ImmutableFlatContainer();

        $this->assertInstanceOf('Iterator', $cont->getIterator());
    }

    public function testHasIsTrue()
    {
        $cont = new ImmutableFlatContainer(['foo' => 'a', 'bar' => 'b', 'baz' => 'c']);

        $this->assertTrue($cont->has('foo'));
    }

    public function testHasIsFalse()
    {
        $cont = new ImmutableFlatContainer(['FOO' => 'a', 'bar' => 'b', 'baz' => 'c']);

        $this->assertFalse($cont->has('foo'));
    }

    public function testRemove()
    {
        $cont = new ImmutableFlatContainer(['foo' => 'a', 'bar' => ['b' => 'c', 'd' => 'e'], 'baz' => 'c']);
        $result = $cont->remove('bar.b');

        $this->assertEquals(['foo' => 'a', 'bar' => ['b' => 'c', 'd' => 'e'], 'baz' => 'c'], $cont->getAll());
        $this->assertEquals(['foo' => 'a', 'bar' => ['d' => 'e'], 'baz' => 'c'], $result->getAll());
        $this->assertNotSame($cont, $result);
        $this->assertInstanceOf(ImmutableFlatContainer::class, $result);
    }

    public function testRemoveMissing()
    {
        $cont = new ImmutableFlatContainer(['foo' => 'a', 'bar' => 'b']);
        $result = $cont->remove('baz');

        $this->assertEquals(['foo' => 'a', 'bar' => 'b'], $cont->getAll());
        $this->assertEquals(['foo' => 'a', 'bar' => 'b'], $result->getAll());
        $this->assertSame($cont, $result);
        $this->assertInstanceOf(ImmutableFlatContainer::class, $result);
    }

    public function testSet()
    {
        $cont = new ImmutableFlatContainer(['foo' => 'a', 'bar' => ['b' => 'c']]);
        $result = $cont->set('bar.d', 'e');

        $this->assertEquals(['foo' => 'a', 'bar' => ['b' => 'c']], $cont->getAll());
        $this->assertEquals(['foo' => 'a', 'bar' => ['b' => 'c', 'd' => 'e']], $result->getAll());
        $this->assertNotSame($cont, $result);
        $this->assertInstanceOf(ImmutableFlatContainer::class, $result);
    }

    public function testSetDuplicate()
    {
        $cont = new ImmutableFlatContainer(['foo' => 'a', 'bar' => ['b' => 'c', 'd' => 'e']]);
        $result = $cont->set('bar.d', 'f');

        $this->assertEquals(['foo' => 'a', 'bar' => ['b' => 'c', 'd' => 'e']], $cont->getAll());
        $this->assertEquals(['foo' => 'a', 'bar' => ['b' => 'c', 'd' => 'f']], $result->getAll());
        $this->assertNotSame($cont, $result);
        $this->assertInstanceOf(ImmutableFlatContainer::class, $result);
    }

    public function testSerialize()
    {
        $cont = new ImmutableFlatContainer(['foo' => 'a', 'bar' => 'b', 'baz' => 'c']);

        $this->assertEquals(
            'C:52:"Graze\DataStructure\Container\ImmutableFlatContainer":60:{a:3:{s:3:"foo";s:1:"a";s:3:"bar";s:1:"b";s:3:"baz";s:1:"c";}}',
            serialize($cont)
        );
    }

    public function testUnserialize()
    {
        $cont = unserialize('C:52:"Graze\DataStructure\Container\ImmutableFlatContainer":60:{a:3:{s:3:"foo";s:1:"a";s:3:"bar";s:1:"b";s:3:"baz";s:1:"c";}}');

        $this->assertEquals(['foo' => 'a', 'bar' => 'b', 'baz' => 'c'], $cont->getAll());
    }

    public function testArrayAccessUnset()
    {
        $cont = new ImmutableFlatContainer(['foo' => 'a', 'bar' => 'b', 'baz' => 'c']);

        unset($cont['baz']);
        $this->assertTrue($cont->has('baz'));
    }

    public function testArrayAccessSet()
    {
        $cont = new ImmutableFlatContainer(['foo' => 'a', 'bar' => 'b', 'baz' => 'c']);

        $cont['baz'] = 'd';
        $this->assertEquals('c', $cont->get('baz'));
    }

    public function testImmutableChildren()
    {
        $cont = new ImmutableFlatContainer(
            ['a' => 'b', 'c' => new Container(['d' => 'e', 'f' => new Container(['g' => 'h'])])]
        );

        $output = $cont->set('c.f.g', 'i');

        $this->assertEquals(
            ['a' => 'b', 'c' => new Container(['d' => 'e', 'f' => new Container(['g' => 'h'])])],
            $cont->getAll()
        );
        $this->assertEquals(
            ['a' => 'b', 'c' => new Container(['d' => 'e', 'f' => new Container(['g' => 'i'])])],
            $output->getAll()
        );
    }

    public function testImmutableChildReferences()
    {
        $child = new Container(['a' => 'b', 'c' => 'd']);
        $container = new ImmutableFlatContainer(['child' => $child]);

        $child->set('c', 'e');

        $this->assertEquals(
            ['child' => new Container(['a' => 'b', 'c' => 'd'])],
            $container->getAll()
        );
    }

    public function testExtractedChildDoesNotModifyParent()
    {
        $cont = new ImmutableFlatContainer(['a' => 'b', 'c' => new Container(['d' => 'e'])]);

        $child = $cont->get('c');

        $child->set('d', 'f');

        $this->assertEquals(
            ['a' => 'b', 'c' => new Container(['d' => 'e'])],
            $cont->getAll(),
            'modifying a child object should not modify the parent container'
        );
    }
}
