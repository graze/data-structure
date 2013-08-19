<?php
namespace Graze\DataStructure\Container;

class ImmutableContainerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->parameters = array('foo' => 'bar');
        $this->container  = new ImmutableContainer($this->parameters);
    }

    public function testContainerInterface()
    {
        $this->assertInstanceOf('Graze\\DataStructure\\Container\\ContainerInterface', $this->container);
    }

    public function testSerializableInterface()
    {
        $this->assertInstanceOf('Serializable', $this->container);
    }

    public function testAddThrows()
    {
        $this->setExpectedException('LogicException');
        $this->container->add('bar', 'baz');
    }

    public function testGet()
    {
        $this->assertSame($this->parameters['foo'], $this->container->get('foo'));
    }

    public function testGetMissing()
    {
        $this->assertNull($this->container->get('bar'));
    }

    public function testGetAll()
    {
        $this->assertSame($this->parameters, $this->container->getAll());
    }

    public function testHas()
    {
        $this->assertTrue($this->container->has('foo'));
    }

    public function testHasMissing()
    {
        $this->assertFalse($this->container->has('bar'));
    }

    public function testSetThrows()
    {
        $this->setExpectedException('LogicException');
        $this->container->set('bar', 'baz');
    }

    public function testRemoveThrows()
    {
        $this->setExpectedException('LogicException');
        $this->container->remove('foo');
    }

    public function testGetIterator()
    {
        $this->assertInstanceOf('Iterator', $this->container->getIterator());
    }

    public function testSerialize()
    {
        $this->assertSame(serialize($this->parameters), $this->container->serialize());
    }

    public function testUnserialize()
    {
        $container = new ImmutableContainer();
        $container->unserialize(serialize($this->parameters));

        $this->assertSame($this->parameters, $container->getAll());
    }
}
