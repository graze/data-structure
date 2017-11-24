<?php

namespace Graze\DataStructure\Container;

use ArrayAccess;
use PHPUnit_Framework_TestCase as TestCase;
use Serializable;
use Traversable;

class ContainerTest extends TestCase
{
    public function testInterface()
    {
        $cont = new Container();

        $this->assertInstanceOf(ContainerInterface::class, $cont);
        $this->assertInstanceOf(Serializable::class, $cont);
        $this->assertInstanceOf(ArrayAccess::class, $cont);
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

    /**
     * @expectedException \Graze\DataStructure\Exception\RegisteredKeyException
     */
    public function testAddDuplicate()
    {
        $cont = new Container(['foo' => 'a', 'bar' => 'b', 'baz' => 'c']);

        $cont->add('baz', 'd');
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
        $this->assertInstanceOf(Traversable::class, $cont);
    }

    public function testIteration()
    {
        $cont = new Container(['a' => 'b', 'c' => 'd']);

        foreach ($cont as $key => $value) {
            switch ($key) {
                case 'a':
                    $this->assertEquals('b', $value);
                    break;
                case 'c':
                    $this->assertEquals('d', $value);
                    break;
                default:
                    $this->fail('unknown key, expecting `a` or `c`');
                    break;
            }
        }
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

        $this->assertEquals(
            'C:39:"Graze\DataStructure\Container\Container":60:{a:3:{s:3:"foo";s:1:"a";s:3:"bar";s:1:"b";s:3:"baz";s:1:"c";}}',
            serialize($cont)
        );
    }

    public function testUnserialize()
    {
        $cont = unserialize('C:39:"Graze\DataStructure\Container\Container":60:{a:3:{s:3:"foo";s:1:"a";s:3:"bar";s:1:"b";s:3:"baz";s:1:"c";}}');

        $this->assertEquals(['foo' => 'a', 'bar' => 'b', 'baz' => 'c'], $cont->getAll());
    }

    public function testArrayGet()
    {
        $cont = new Container(['foo' => 'a', 'bar' => 'b', 'baz' => 'c']);

        $this->assertEquals('a', $cont['foo']);
    }

    public function testArraySet()
    {
        $cont = new Container(['foo' => 'a', 'bar' => 'b']);
        $cont['baz'] = 'c';

        $this->assertEquals(['foo' => 'a', 'bar' => 'b', 'baz' => 'c'], $cont->getAll());
    }

    public function testArrayHasIsTrue()
    {
        $cont = new Container(['foo' => 'a', 'bar' => 'b', 'baz' => 'c']);

        $this->assertTrue(isset($cont['foo']));
    }

    public function testArrayHasIsFalse()
    {
        $cont = new Container(['FOO' => 'a', 'bar' => 'b', 'baz' => 'c']);

        $this->assertFalse(isset($cont['foo']));
    }

    public function testArrayRemove()
    {
        $cont = new Container(['foo' => 'a', 'bar' => 'b', 'baz' => 'c']);
        unset($cont['bar']);

        $this->assertEquals(['foo' => 'a', 'baz' => 'c'], $cont->getAll());
    }

    public function testArrayRemoveMissing()
    {
        $cont = new Container(['foo' => 'a', 'bar' => 'b']);
        unset($cont['baz']);

        $this->assertEquals(['foo' => 'a', 'bar' => 'b'], $cont->getAll());
    }
}
