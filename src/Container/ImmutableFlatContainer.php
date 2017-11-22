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

class ImmutableFlatContainer extends FlatContainer
{
    /**
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        parent::__construct([]);

        foreach ($params as $key => $value) {
            $this->doSet($key, $value);
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
        $cont->doSet($key, $value);

        return $cont;
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
            $cont->doRemove($key);

            return $cont;
        }

        return $this;
    }
}
