<?php
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
