<?php
/*
 * This file is part of Data Structure
 *
 * Copyright (c) 2013 Nature Delivered Ltd. <http://graze.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see  http://github.com/graze/DataStructure/blob/master/LICENSE
 * @link http://github.com/graze/DataStructure
 */
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
     * return array
     */
    public function getAll();

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
