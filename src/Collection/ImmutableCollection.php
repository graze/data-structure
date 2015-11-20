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
        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function add($value)
    {
        $items = $this->items;
        $items[] = $value;

        return new self($items);
    }

    /**
     * {@inheritdoc}
     */
    public function filter($fn)
    {
        return new self(array_filter($this->items, $fn));
    }

    /**
     * {@inheritdoc}
     */
    public function sort($fn)
    {
        $items = $this->items;
        usort($items, $fn);

        return new self($items);
    }

    /**
     * {@inheritdoc}
     */
    public function sortOn($fn, $order = Sort\ASC)
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
