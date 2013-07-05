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
     * @param Closure $callable
     * @return array
     */
    public function filter(\Closure $callable);

    /**
     * @param Closure $callable
     * @return array
     */
    public function map(\Closure $callable);

    /**
     * @param Closure $callable
     * @return array
     */
    public function sort(\Closure $callable);
}
