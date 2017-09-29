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

use Graze\Sort;

class ImmutableCollection extends Collection
{
    /**
     * @param mixed[] $items
     */
    public function __construct(array $items = [])
    {
        parent::__construct([]);

        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    /**
     * @param mixed $value
     *
     * @return ImmutableCollection
     */
    public function add($value)
    {
        $items = $this->items;
        $items[] = $value;

        return new self($items);
    }

    /**
     * @param callable $fn
     *
     * @return ImmutableCollection
     */
    public function filter(callable $fn)
    {
        return new self(array_filter($this->items, $fn));
    }

    /**
     * @param callable $fn
     *
     * @return ImmutableCollection
     */
    public function sort(callable $fn)
    {
        $items = $this->items;
        usort($items, $fn);

        return new self($items);
    }

    /**
     * @param callable $fn
     * @param int      $order
     *
     * @return ImmutableCollection
     */
    public function sortOn(callable $fn, $order = Sort\ASC)
    {
        return new self(Sort\comparison($this->items, $fn, $order));
    }

    /**
     * @param mixed $value
     */
    protected function addItem($value)
    {
        parent::add($value);
    }
}
