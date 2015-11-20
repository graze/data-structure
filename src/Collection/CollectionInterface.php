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

use Countable;
use Graze\Sort;
use IteratorAggregate;

interface CollectionInterface extends Countable, IteratorAggregate
{
    /**
     * @param mixed $value
     *
     * @return CollectionInterface
     */
    public function add($value);

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function contains($value);

    /**
     * return array.
     */
    public function getAll();

    /**
     * @param callable $fn
     *
     * @return CollectionInterface
     */
    public function filter($fn);

    /**
     * @param callable $fn
     *
     * @return mixed[]
     */
    public function map($fn);

    /**
     * @param callable $fn
     * @param mixed $initial
     *
     * @return mixed
     */
    public function reduce($fn, $initial = null);

    /**
     * @link http://php.net/manual/en/function.usort.php
     *
     * @param callable $fn
     *
     * @return CollectionInterface
     */
    public function sort($fn);

    /**
     * @param callable $fn
     * @param int $order
     *
     * @return CollectionInterface
     */
    public function sortOn($fn, $order = Sort\ASC);
}
