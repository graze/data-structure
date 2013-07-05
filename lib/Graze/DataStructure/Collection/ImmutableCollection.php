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
     * @return CollectionInterface
     */
    public function filter(\Closure $closure)
    {
        return new Collection(array_filter($this->items, $closure));
    }
}
