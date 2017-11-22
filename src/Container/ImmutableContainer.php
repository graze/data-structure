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
     * @return ImmutableContainer
     */
    public function set($key, $value)
    {
        $cont = clone $this;
        $cont->setParameter($key, $value);

        return $cont;
    }

    /**
     * @param string $key
     *
     * @return $this
     */
    public function remove($key)
    {
        if ($this->has($key)) {
            $params = $this->params;
            unset($params[$key]);

            return new self($params);
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
        return parent::set($key, $value);
    }
}
