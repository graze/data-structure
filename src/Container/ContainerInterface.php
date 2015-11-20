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

use Graze\DataStructure\Exception\RegisteredKeyException;
use IteratorAggregate;

interface ContainerInterface extends IteratorAggregate
{
    /**
     * @param string $key
     * @param mixed $value
     *
     * @throws RegisteredKeyException If value with `$key` is already registered
     *
     * @return ContainerInterface
     */
    public function add($key, $value);

    /**
     * @param callable $fn
     */
    public function forAll($fn);

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get($key);

    /**
     * @return array
     */
    public function getAll();

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key);

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return ContainerInterface
     */
    public function set($key, $value);

    /**
     * @param string $key
     *
     * @return ContainerInterface
     */
    public function remove($key);
}
