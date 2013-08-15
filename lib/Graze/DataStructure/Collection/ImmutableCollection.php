<?php
namespace Graze\DataStructure\Collection;

use LogicException;

class ImmutableCollection extends Collection
{
    /**
     * @param array $items
     */
    public function __construct(array $items)
    {
        foreach ($items as $item) {
            parent::add($item);
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
        return array_filter($this->items, $closure);
    }

    /**
     * @param Closure $closure
     * @return array
     */
    public function map(\Closure $closure)
    {
        return array_map($this->items, $closure);
    }

    /**
     * @param Closure $closure
     * @return array
     */
    public function reduce(\Closure $closure)
    {
        return array_reduce($this->items, $closure);
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
