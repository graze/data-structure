<?php

namespace Graze\DataStructure\Container;

use ArrayAccess;

/**
 * CollapsedContainer accepts key access using a delimiter to represent child arrays
 *
 * ## Examples
 *
 * ```php
 * $container = new CollapsedContainer(['first' => 'value', 'second' => ['child' => 1, 'other' => 2]]);
 *
 * ($container->get('second.child') === 1)
 * // true
 *
 * ($container->has('first.child'))
 * // false
 *
 * $container->set('second.third', 3);
 * $container->getAll();
 * // ['first' => 'value', 'second' => ['child' => 1, 'other' => 2, 'third'=> 3]]
 *
 * $container->remove('second.other');
 * $container->getAll();
 * // ['first' => 'value', 'second' => ['child' => 1, 'third'=> 3]]
 * ```
 */
class CollapsedContainer extends Container
{
    const DELIMITER = '.';

    /**
     * @param string $key
     *
     * @return mixed|null
     */
    public function get($key)
    {
        if (mb_strpos($key, static::DELIMITER) !== false) {
            $top = $this->params;

            foreach (explode(static::DELIMITER, $key) as $node) {
                if (!isset($top[$node])) {
                    return null;
                }
                $top = $top[$node];
            }
            return $top;
        }

        return parent::get($key);
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this|ContainerInterface
     */
    public function set($key, $value)
    {
        if (mb_strpos($key, static::DELIMITER) !== false) {
            $split = explode(static::DELIMITER, $key);
            $key = implode(static::DELIMITER, array_slice($split, 0, -1));
            $top = $this->get($key);
            if (is_null($top) || (!is_array($top) && !($top instanceof ArrayAccess))) {
                $top = [];
            }

            $last = $split[count($split) - 1];
            if ($top instanceof ContainerInterface) {
                $top = $top->set($last, $value);
            } else {
                $top[$last] = $value;
            }

            return $this->set($key, $top);
        }

        return parent::set($key, $value);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        if (mb_strpos($key, static::DELIMITER) !== false) {
            $top = $this->params;

            foreach (explode(static::DELIMITER, $key) as $node) {
                if (!isset($top[$node])) {
                    return false;
                }
                $top = $top[$node];
            }
            return true;
        }
        return parent::has($key);
    }

    /**
     * @param string $key
     *
     * @return $this|ContainerInterface
     */
    public function remove($key)
    {
        if (mb_strpos($key, static::DELIMITER) !== false) {
            $split = explode(static::DELIMITER, $key);
            $key = implode(static::DELIMITER, array_slice($split, 0, -1));
            $top = $this->get($key);
            if (is_null($top) || (!is_array($top) && !($top instanceof ArrayAccess))) {
                return $this;
            }

            $last = $split[count($split) - 1];
            if ($top instanceof ContainerInterface) {
                $top = $top->remove($last);
            } else {
                unset($top[$last]);
            }

            return $this->set($key, $top);
        }

        return parent::remove($key);
    }
}
