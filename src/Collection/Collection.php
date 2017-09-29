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

namespace Graze\DataStructure\Collection;

use ArrayIterator;
use Graze\Sort;
use Serializable;

class Collection implements CollectionInterface, Serializable
{
    /**
     * @var mixed[]
     */
    protected $items = [];

    /**
     * @param mixed[] $items
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function add($value)
    {
        $this->items[] = $value;

        return $this;
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function contains($value)
    {
        return in_array($value, $this->items, true);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * @param callable $fn
     *
     * @return $this
     */
    public function filter(callable $fn)
    {
        $this->items = array_values(array_filter($this->items, $fn));

        return $this;
    }

    /**
     * @return mixed[]
     */
    public function getAll()
    {
        return $this->items;
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * @param callable $fn
     *
     * @return array
     */
    public function map(callable $fn)
    {
        return array_map($fn, $this->items);
    }

    /**
     * @param callable   $fn
     * @param mixed|null $initial
     *
     * @return mixed
     */
    public function reduce(callable $fn, $initial = null)
    {
        return array_reduce($this->items, $fn, $initial);
    }

    /**
     * @param callable $fn
     *
     * @return $this
     */
    public function sort(callable $fn)
    {
        usort($this->items, $fn);

        return $this;
    }

    /**
     * @param callable $fn
     * @param int      $order
     *
     * @return $this
     */
    public function sortOn(callable $fn, $order = Sort\ASC)
    {
        $this->items = Sort\comparison($this->items, $fn, $order);

        return $this;
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize($this->items);
    }

    /**
     * @param string $data
     */
    public function unserialize($data)
    {
        $this->items = unserialize($data);
    }
}
