<?php
/*
 * This file is part of Graze DataStructure
 *
 * Copyright (c) 2017 Nature Delivered Ltd. <http://graze.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see  http://github.com/graze/data-structure/blob/master/LICENSE
 * @link http://github.com/graze/data-structure
 */

namespace Graze\DataStructure\Container;

use ArrayAccess;

/**
 * FlatContainer accepts key access using a delimiter to represent child arrays
 *
 * ## Examples
 *
 * ```php
 * $container = new FlatContainer(['first' => 'value', 'second' => ['child' => 1, 'other' => 2]]);
 *
 * $container->get('second.child')
 * // 1
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
class FlatContainer extends Container
{
    const DELIMITER = '.';

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        if (mb_strpos($key, static::DELIMITER) !== false) {
            $top = $this->getAll();

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
     * @return mixed|null
     */
    public function get($key)
    {
        if (mb_strpos($key, static::DELIMITER) !== false) {
            $top = $this->getAll();

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
     * @return ContainerInterface
     */
    public function set($key, $value)
    {
        return $this->doSet($key, $value);
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return ContainerInterface
     */
    protected function doSet($key, $value)
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

            return $this->doSet($key, $top);
        }

        return parent::set($key, $value);
    }

    /**
     * @param string $key
     *
     * @return ContainerInterface
     */
    public function remove($key)
    {
        return $this->doRemove($key);
    }

    /**
     * @param string $key
     *
     * @return ContainerInterface
     */
    protected function doRemove($key)
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

            return $this->doSet($key, $top);
        }

        return parent::remove($key);
    }
}
