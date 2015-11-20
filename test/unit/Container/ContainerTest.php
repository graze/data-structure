<?php

namespace Graze\DataStructure\Container;

use Graze\Sort as s;
use PHPUnit_Framework_TestCase as TestCase;

class ContainerTest extends TestCase
{
    public function testInterface()
    {
        $cont = new Container();

        $this->assertInstanceOf('Graze\DataStructure\Container\ContainerInterface', $cont);
        $this->assertInstanceOf('Serializable', $cont);
    }

    public function testConstructor()
    {
        $params = ['foo' => 'a', 'bar' => 'b', 'baz' => 'c'];
        $cont = new Container($params);

        $this->assertEquals($params, $cont->getAll());
    }

    public function testAdd()
    {
        $cont = new Container(['foo' => 'a', 'bar' => 'b']);
        $result = $cont->add('baz', 'c');

        $this->assertEquals(['foo' => 'a', 'bar' => 'b', 'baz' => 'c'], $cont->getAll());
        $this->assertSame($cont, $result);
    }

    public function testAddDuplicate()
    {
        $cont = new Container(['foo' => 'a', 'bar' => 'b', 'baz' => 'c']);

        $this->setExpectedException('Graze\DataStructure\Exception\RegisteredKeyException');
        $result = $cont->add('baz', 'd');
    }

    public function testForAll()
    {
        $params = ['foo' => 'a', 'bar' => 'b', 'baz' => 'c'];
        $seen = [];

        $cont = new Container($params);
        $cont->forAll(function ($value, $key) use (&$seen) {
            $seen[$key] = $value;
        });

        $this->assertEquals($params, $seen);
    }

    public function testGet()
    {
        $cont = new Container(['foo' => 'a', 'bar' => 'b', 'baz' => 'c']);

        $this->assertEquals('a', $cont->get('foo'));
    }

    public function testGetMissing()
    {
        $cont = new Container();

        $this->assertNull($cont->get('foo'));
    }

    public function testGetIterator()
    {
        $cont = new Container();

        $this->assertInstanceOf('Iterator', $cont->getIterator());
    }

    public function testHasIsTrue()
    {
        $cont = new Container(['foo' => 'a', 'bar' => 'b', 'baz' => 'c']);

        $this->assertTrue($cont->has('foo'));
    }

    public function testHasIsFalse()
    {
        $cont = new Container(['FOO' => 'a', 'bar' => 'b', 'baz' => 'c']);

        $this->assertFalse($cont->has('foo'));
    }

    public function testRemove()
    {
        $cont = new Container(['foo' => 'a', 'bar' => 'b', 'baz' => 'c']);
        $result = $cont->remove('bar');

        $this->assertEquals(['foo' => 'a', 'baz' => 'c'], $cont->getAll());
        $this->assertSame($cont, $result);
    }

    public function testRemoveMissing()
    {
        $cont = new Container(['foo' => 'a', 'bar' => 'b']);
        $result = $cont->remove('baz');

        $this->assertEquals(['foo' => 'a', 'bar' => 'b'], $cont->getAll());
        $this->assertSame($cont, $result);
    }

    public function testSet()
    {
        $cont = new Container(['foo' => 'a', 'bar' => 'b']);
        $result = $cont->set('baz', 'c');

        $this->assertEquals(['foo' => 'a', 'bar' => 'b', 'baz' => 'c'], $cont->getAll());
        $this->assertSame($cont, $result);
    }

    public function testSetDuplicate()
    {
        $cont = new Container(['foo' => 'a', 'bar' => 'b', 'baz' => 'c']);
        $result = $cont->set('baz', 'd');

        $this->assertEquals(['foo' => 'a', 'bar' => 'b', 'baz' => 'd'], $cont->getAll());
        $this->assertSame($cont, $result);
    }

    public function testSerialize()
    {
        $cont = new Container(['foo' => 'a', 'bar' => 'b', 'baz' => 'c']);

        $this->assertEquals('C:39:"Graze\DataStructure\Container\Container":60:{a:3:{s:3:"foo";s:1:"a";s:3:"bar";s:1:"b";s:3:"baz";s:1:"c";}}', serialize($cont));
    }

    public function testUnserialize()
    {
        $cont = unserialize('C:39:"Graze\DataStructure\Container\Container":60:{a:3:{s:3:"foo";s:1:"a";s:3:"bar";s:1:"b";s:3:"baz";s:1:"c";}}');

        $this->assertEquals(['foo' => 'a', 'bar' => 'b', 'baz' => 'c'], $cont->getAll());
    }
}
