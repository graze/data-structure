<?php
/*
 * This file is part of Graze DataStructure
 *
 * Copyright (c) 2017 Nature Delivered Ltd. <http://graze.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see  http://github.com/graze/data-structure/blob/master/LICENSE
 * @link http://github.com/graze/data-structure
 */

namespace Graze\DataStructure\Container;

/**
 * ImmutableFlatContainer can access data in child arrays and containers, any modification is immutable
 * (for the top level) but can modify child containers
 *
 * ```php
 * $container = new ImmutableFlatContainer(['a'=>'b']);
 * $new = $container->set('c', 'd');
 * $container->getAll();
 * // ['a' => 'b']
 * $new->getAll()
 * // ['a' => 'b', 'c' => 'd']
 *
 * $child = new Container(['a' => 'b']);
 * $container = new ImmutableFlatContainer([
 * ```
 */
class ImmutableFlatContainer extends FlatContainer
{
    /**
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        parent::__construct([]);

        foreach ($params as $key => $value) {
            $this->doSet($key, $this->recursiveClone($value));
        }
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return ContainerInterface
     */
    public function set($key, $value)
    {
        $cont = clone $this;
        $cont->doSet($key, $this->recursiveClone($value));

        return $cont;
    }

    /**
     * Clone children to ensure any modifications can not change this objects contents
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return $this->recursiveClone(parent::get($key));
    }

    /**
     * @param string $key
     *
     * @return ContainerInterface
     */
    public function remove($key)
    {
        if ($this->has($key)) {
            $cont = clone $this;
            $cont->doRemove($key);

            return $cont;
        }

        return $this;
    }
}
