<?php
/*
 * This file is part of Graze DataStructure
 *
 * Copyright (c) 2014 Nature Delivered Ltd. <http://graze.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see  http://github.com/graze/data-structure/blob/master/LICENSE
 * @link http://github.com/graze/data-structure
 */

namespace Graze\DataStructure\Container;

use ArrayIterator;
use Graze\DataStructure\Exception\RegisteredKeyException;
use Serializable;

class Container implements ContainerInterface, Serializable
{
    /**
     * @var array
     */
    protected $params = [];

    /**
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        foreach ($params as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return Container
     */
    public function add($key, $value)
    {
        if ($this->has($key)) {
            throw new RegisteredKeyException($key);
        }

        return $this->set($key, $value);
    }

    /**
     * @param callable $fn
     */
    public function forAll(callable $fn)
    {
        foreach ($this->params as $key => $value) {
            call_user_func($fn, $value, $key);
        }
    }

    /**
     * @param string $key
     *
     * @return mixed|null
     */
    public function get($key)
    {
        return $this->has($key) ? $this->params[$key] : null;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->params;
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->params);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return isset($this->params[$key]);
    }

    /**
     * @param string $key
     *
     * @return $this
     */
    public function remove($key)
    {
        if ($this->has($key)) {
            unset($this->params[$key]);
        }

        return $this;
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function set($key, $value)
    {
        $this->params[$key] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize($this->params);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $data The string representation of the object.
     *
     * @return void
     */
    public function unserialize($data)
    {
        $this->params = unserialize($data);
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed $offset An offset to check for.
     *
     * @return bool true on success or false on failure.
     *              The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed $offset The offset to retrieve.
     *
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed $offset The offset to assign the value to.
     * @param mixed $value  The value to set.
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed $offset The offset to unset.
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    /**
     * @param mixed $item
     *
     * @return mixed
     */
    protected function recursiveClone($item)
    {
        if (is_object($item)) {
            return clone $item;
        } elseif (is_array($item)) {
            return array_map([$this, 'recursiveClone'], $item);
        }
        return $item;
    }

    /**
     * Clone all child objects (in the array tree)
     */
    public function __clone()
    {
        $this->params = array_map([$this, 'recursiveClone'], $this->params);
    }
}
