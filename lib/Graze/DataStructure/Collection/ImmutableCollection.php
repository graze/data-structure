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
namespace Graze\DataStructure\Collection;

use LogicException;

class ImmutableCollection extends Collection
{
    /**
     * @param array $items
     */
    public function __construct(array $items = array())
    {
        foreach ($items as $item) {
            $this->items[] = $item;
        }
    }

    /**
     * @param mixed $value
     */
    public function add($value)
    {
        throw new LogicException('Collection can\'t be modified after construction.');
    }

    /**
     * @param Closure $closure
     * @return array
     */
    public function filter(\Closure $closure)
    {
        return array_values(array_filter($this->items, $closure));
    }

    /**
     * @param Closure $closure
     * @return array
     */
    public function map(\Closure $closure)
    {
        return array_map($closure, $this->items);
    }

    /**
     * @param Closure $closure
     * @param mixed $initial
     * @return array
     */
    public function reduce(\Closure $closure, $initial = null)
    {
        return array_reduce($this->items, $closure, $initial);
    }

    /**
     * @param Closure $closure
     * @return array
     */
    public function sort(\Closure $closure)
    {
        $items = $this->items;
        @usort($items, $closure);

        return $items;
    }
}
