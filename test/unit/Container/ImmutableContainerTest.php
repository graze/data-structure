<?php

namespace Graze\DataStructure\Container;

use Graze\Sort as s;
use PHPUnit_Framework_TestCase as TestCase;

class ImmutableContainerTest extends TestCase
{
    public function testInterface()
    {
        $cont = new ImmutableContainer();

        $this->assertInstanceOf('Graze\DataStructure\Container\ContainerInterface', $cont);
        $this->assertInstanceOf('Serializable', $cont);
    }

    public function testConstructor()
    {
        $params = ['foo' => 'a', 'bar' => 'b', 'baz' => 'c'];
        $cont = new ImmutableContainer($params);

        $this->assertEquals($params, $cont->getAll());
    }

    public function testAdd()
    {
        $cont = new ImmutableContainer(['foo' => 'a', 'bar' => 'b']);
        $result = $cont->add('baz', 'c');

        $this->assertEquals(['foo' => 'a', 'bar' => 'b'], $cont->getAll());
        $this->assertEquals(['foo' => 'a', 'bar' => 'b', 'baz' => 'c'], $result->getAll());
        $this->assertNotSame($cont, $result);
        $this->assertInstanceOf('Graze\DataStructure\Container\ImmutableContainer', $result);
    }

    public function testAddDuplicate()
    {
        $cont = new ImmutableContainer(['foo' => 'a', 'bar' => 'b', 'baz' => 'c']);

        $this->setExpectedException('Graze\DataStructure\Exception\RegisteredKeyException');
        $result = $cont->add('baz', 'd');
    }

    public function testForAll()
    {
        $params = ['foo' => 'a', 'bar' => 'b', 'baz' => 'c'];
        $seen = [];

        $cont = new ImmutableContainer($params);
        $cont->forAll(function ($value, $key) use (&$seen) {
            $seen[$key] = $value;
        });

        $this->assertEquals($params, $seen);
    }

    public function testGet()
    {
        $cont = new ImmutableContainer(['foo' => 'a', 'bar' => 'b', 'baz' => 'c']);

        $this->assertEquals('a', $cont->get('foo'));
    }

    public function testGetMissing()
    {
        $cont = new ImmutableContainer();

        $this->assertNull($cont->get('foo'));
    }

    public function testGetIterator()
    {
        $cont = new ImmutableContainer();

        $this->assertInstanceOf('Iterator', $cont->getIterator());
    }

    public function testHasIsTrue()
    {
        $cont = new ImmutableContainer(['foo' => 'a', 'bar' => 'b', 'baz' => 'c']);

        $this->assertTrue($cont->has('foo'));
    }

    public function testHasIsFalse()
    {
        $cont = new ImmutableContainer(['FOO' => 'a', 'bar' => 'b', 'baz' => 'c']);

        $this->assertFalse($cont->has('foo'));
    }

    public function testRemove()
    {
        $cont = new ImmutableContainer(['foo' => 'a', 'bar' => 'b', 'baz' => 'c']);
        $result = $cont->remove('bar');

        $this->assertEquals(['foo' => 'a', 'bar' => 'b', 'baz' => 'c'], $cont->getAll());
        $this->assertEquals(['foo' => 'a', 'baz' => 'c'], $result->getAll());
        $this->assertNotSame($cont, $result);
        $this->assertInstanceOf('Graze\DataStructure\Container\ImmutableContainer', $result);
    }

    public function testRemoveMissing()
    {
        $cont = new ImmutableContainer(['foo' => 'a', 'bar' => 'b']);
        $result = $cont->remove('baz');

        $this->assertEquals(['foo' => 'a', 'bar' => 'b'], $cont->getAll());
        $this->assertEquals(['foo' => 'a', 'bar' => 'b'], $result->getAll());
        $this->assertSame($cont, $result);
        $this->assertInstanceOf('Graze\DataStructure\Container\ImmutableContainer', $result);
    }

    public function testSet()
    {
        $cont = new ImmutableContainer(['foo' => 'a', 'bar' => 'b']);
        $result = $cont->set('baz', 'c');

        $this->assertEquals(['foo' => 'a', 'bar' => 'b'], $cont->getAll());
        $this->assertEquals(['foo' => 'a', 'bar' => 'b', 'baz' => 'c'], $result->getAll());
        $this->assertNotSame($cont, $result);
        $this->assertInstanceOf('Graze\DataStructure\Container\ImmutableContainer', $result);
    }

    public function testSetDuplicate()
    {
        $cont = new ImmutableContainer(['foo' => 'a', 'bar' => 'b', 'baz' => 'c']);
        $result = $cont->set('baz', 'd');

        $this->assertEquals(['foo' => 'a', 'bar' => 'b', 'baz' => 'c'], $cont->getAll());
        $this->assertEquals(['foo' => 'a', 'bar' => 'b', 'baz' => 'd'], $result->getAll());
        $this->assertNotSame($cont, $result);
        $this->assertInstanceOf('Graze\DataStructure\Container\ImmutableContainer', $result);
    }

    public function testSerialize()
    {
        $cont = new ImmutableContainer(['foo' => 'a', 'bar' => 'b', 'baz' => 'c']);

        $this->assertEquals('C:48:"Graze\DataStructure\Container\ImmutableContainer":60:{a:3:{s:3:"foo";s:1:"a";s:3:"bar";s:1:"b";s:3:"baz";s:1:"c";}}', serialize($cont));
    }

    public function testUnserialize()
    {
        $cont = unserialize('C:48:"Graze\DataStructure\Container\ImmutableContainer":60:{a:3:{s:3:"foo";s:1:"a";s:3:"bar";s:1:"b";s:3:"baz";s:1:"c";}}');

        $this->assertEquals(['foo' => 'a', 'bar' => 'b', 'baz' => 'c'], $cont->getAll());
    }
}
