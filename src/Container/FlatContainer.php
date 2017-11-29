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
use RecursiveArrayIterator;

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
 * $container->has('first.child')
 * // false
 *
 * $container->set('second.third', 3);
 * $container->getAll();
 * // ['first' => 'value', 'second' => ['child' => 1, 'other' => 2, 'third' => 3]]
 *
 * $container->remove('second.other');
 * $container->getAll();
 * // ['first' => 'value', 'second' => ['child' => 1, 'third' => 3]]
 * ```
 */
class FlatContainer extends Container
{
    const DEFAULT_DELIMITER = '.';

    /** @var string */
    protected $delimiter = self::DEFAULT_DELIMITER;

    /**
     * @param string $key
     *
     * @return mixed|null
     */
    private function getChild($key)
    {
        $top = $this->params;

        foreach (explode($this->delimiter, $key) as $node) {
            if (!isset($top[$node])) {
                return null;
            }
            $top = $top[$node];
        }
        return $top;
    }

    /**
     * @param string $key
     *
     * @return string[] split the key into everything up to the last delimiter, and the last key
     */
    private function splitToLast($key)
    {
        $split = explode($this->delimiter, $key);
        $key = implode($this->delimiter, array_slice($split, 0, -1));
        $last = end($split);

        return [$key, $last];
    }

    /**
     * @param string $key The key to access, supports delimiter based child access (e.g. `parent.child.node`)
     *
     * @return bool
     */
    public function has($key)
    {
        if (mb_strpos($key, $this->delimiter) !== false) {
            return (!is_null($this->getChild($key)));
        }
        return parent::has($key);
    }

    /**
     * @param string $key The key to access, supports delimiter based child access (e.g. `parent.child.node`)
     *
     * @return mixed|null
     */
    public function get($key)
    {
        if (mb_strpos($key, $this->delimiter) !== false) {
            return $this->getChild($key);
        }

        return parent::get($key);
    }

    /**
     * @param string $key The key to access, supports delimiter based child access (e.g. `parent.child.node`)
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
        if (mb_strpos($key, $this->delimiter) !== false) {
            list($key, $last) = $this->splitToLast($key);

            $top = $this->get($key);
            if (is_null($top) || (!is_array($top) && !($top instanceof ArrayAccess))) {
                $top = [];
            }

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
     * @param string $key The key to access, supports delimiter based child access (e.g. `parent.child.node`)
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
        if (mb_strpos($key, $this->delimiter) !== false) {
            list($key, $last) = $this->splitToLast($key);

            $top = $this->get($key);
            if (is_null($top) || (!is_array($top) && !($top instanceof ArrayAccess))) {
                return $this;
            }

            if ($top instanceof ContainerInterface) {
                $top = $top->remove($last);
            } else {
                unset($top[$last]);
            }

            return $this->doSet($key, $top);
        }

        return parent::remove($key);
    }

    /**
     * @param string $delimiter
     *
     * @return FlatContainer
     */
    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;
        return $this;
    }

    /**
     * @return string
     */
    public function getDelimiter()
    {
        return $this->delimiter;
    }
}
