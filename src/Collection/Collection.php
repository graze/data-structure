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
     * {@inheritdoc}
     */
    public function add($value)
    {
        $this->items[] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function contains($value)
    {
        return in_array($value, $this->items, true);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function filter($fn)
    {
        $this->items = array_values(array_filter($this->items, $fn));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        return $this->items;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function map($fn)
    {
        return array_map($fn, $this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function reduce($fn, $initial = null)
    {
        return array_reduce($this->items, $fn, $initial);
    }

    /**
     * {@inheritdoc}
     */
    public function sort($fn)
    {
        usort($this->items, $fn);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function sortOn($fn, $order = Sort\ASC)
    {
        $this->items = Sort\comparison($this->items, $fn, $order);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($data)
    {
        $this->items = unserialize($data);
    }
}
