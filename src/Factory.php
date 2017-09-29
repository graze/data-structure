<?php

namespace Graze\DataStructure;

use Graze\DataStructure\Collection\Collection;
use Graze\DataStructure\Collection\CollectionInterface;
use Graze\DataStructure\Container\Container;
use Graze\DataStructure\Container\ContainerInterface;

class Factory
{
    /** @var string */
    private $collectionClass = Collection::class;

    /** @var string */
    private $containerClass = Container::class;

    /**
     * Factory constructor.
     *
     * @param string $collectionClass
     * @param string $containerClass
     */
    public function __construct($collectionClass = Collection::class, $containerClass = Container::class)
    {
        $this->collectionClass = $collectionClass;
        $this->containerClass = $containerClass;
    }

    /**
     * Recursively build collection/container based on input array
     *
     * @param array $array
     *
     * @return CollectionInterface|ContainerInterface
     */
    public function build(array $array = [])
    {
        $out = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $out[$key] = $this->build($value);
            } else {
                $out[$key] = $value;
            }
        }
        $class = $this->isAssoc($array) ? $this->containerClass : $this->collectionClass;
        return new $class($out);
    }

    /**
     * Is the supplied $array associative or not?
     *
     * @param array $array
     *
     * @return bool
     */
    private function isAssoc(array $array = [])
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }
}
