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
     * {@inheritdoc}
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
    public function forAll($fn)
    {
        foreach ($this->params as $key => $value) {
            call_user_func($fn, $value, $key);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        return $this->has($key) ? $this->params[$key] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        return $this->params;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->params);
    }

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        return isset($this->params[$key]);
    }

    /**
     * {@inheritdoc}
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
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $this->params[$key] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize($this->params);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($data)
    {
        $this->params = unserialize($data);
    }
}
