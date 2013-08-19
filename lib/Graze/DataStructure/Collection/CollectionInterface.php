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

interface CollectionInterface extends \Countable, \IteratorAggregate
{
    /**
     * @param mixed $value
     */
    public function add($value);

    /**
     * @param mixed $value
     * @return boolean
     */
    public function contains($value);

    /**
     * return array
     */
    public function getAll();

    /**
     * @param Closure $closure
     * @return array
     */
    public function filter(\Closure $closure);

    /**
     * @param Closure $closure
     * @return array
     */
    public function map(\Closure $closure);

    /**
     * @param Closure $closure
     * return CollectionInterface
     */
    public function reduce(\Closure $closure);

    /**
     * @param Closure $closure
     * @return array
     */
    public function sort(\Closure $closure);
}
