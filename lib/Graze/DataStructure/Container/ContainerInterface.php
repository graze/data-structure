<?php
namespace Graze\DataStructure\Container;

interface ContainerInterface extends \IteratorAggregate
{
    /**
     * @param string $key
     * @param mixed $value
     */
    public function add($key, $value);

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key);

    /**
     * @param string $key
     * @return boolean
     */
    public function has($key);

    /**
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value);

    /**
     * @param string $key
     */
    public function remove($key);
}
