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

namespace Graze\DataStructure\Container;

class ImmutableContainer extends Container
{
    /**
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        parent::__construct([]);

        foreach ($params as $key => $value) {
            $this->setParameter($key, $value);
        }
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return ContainerInterface
     */
    public function set($key, $value)
    {
        $cont = clone $this;
        $cont->setParameter($key, $value);

        return $cont;
    }

    /**
     * Clone the returned value to ensure any modification does not change our version
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return $this->recursiveClone(parent::get($key));
    }

    /**
     * @param string $key
     *
     * @return ContainerInterface
     */
    public function remove($key)
    {
        if ($this->has($key)) {
            $cont = clone $this;
            $cont->removeParameter($key);

            return $cont;
        }

        return $this;
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return ContainerInterface
     */
    protected function setParameter($key, $value)
    {
        return parent::set($key, $this->recursiveClone($value));
    }

    /**
     * @param string $key
     *
     * @return ContainerInterface
     */
    protected function removeParameter($key)
    {
        return parent::remove($key);
    }
}
