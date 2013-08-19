<?php
namespace Graze\DataStructure\Container;

class ContainerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->parameters = array('foo' => 'bar');
        $this->container  = new Container($this->parameters);
    }

    public function testContainerInterface()
    {
        $this->assertInstanceOf('Graze\\DataStructure\\Container\\ContainerInterface', $this->container);
    }

    public function testSerializableInterface()
    {
        $this->assertInstanceOf('Serializable', $this->container);
    }

    public function testAdd()
    {
        $this->container->add('bar', 'baz');
        $this->assertSame('baz', $this->container->get('bar'));
    }

    public function testAddExistingThrows()
    {
        $this->setExpectedException('OutOfBoundsException');
        $this->container->add('foo', 'baz');
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

    public function testSet()
    {
        $this->container->set('bar', 'baz');
        $this->assertSame('baz', $this->container->get('bar'));
    }

    public function testSetExisting()
    {
        $this->container->set('foo', 'baz');
        $this->assertSame('baz', $this->container->get('foo'));
    }

    public function testRemove()
    {
        $this->container->remove('foo');
        $this->assertNull($this->container->get('foo'));
    }

    public function testRemoveMissing()
    {
        $this->container->remove('bar');
        $this->assertNull($this->container->get('bar'));
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
        $container = new Container();
        $container->unserialize(serialize($this->parameters));

        $this->assertSame($this->parameters, $container->getAll());
    }
}
