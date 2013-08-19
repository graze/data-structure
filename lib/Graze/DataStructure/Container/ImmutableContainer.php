<?php
/*
 * This file is part of Data Structure
 *
 * Copyright (c) 2013 Nature Delivered Ltd. <http://graze.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see  http://github.com/graze/DataStructure/blob/master/LICENSE
 * @link http://github.com/graze/DataStructure
 */
namespace Graze\DataStructure\Container;

use LogicException;

class ImmutableContainer extends Container
{
    /**
     * @param array $parameters
     */
    public function __construct(array $parameters = array())
    {
        foreach ($parameters as $key => $value) {
            $this->parameters[$key] = $value;
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function add($key, $value)
    {
        throw new LogicException('Container can\'t be modified after construction.');
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        throw new LogicException('Container can\'t be modified after construction.');
    }

    /**
     * @param string $key
     */
    public function remove($key)
    {
        throw new LogicException('Container can\'t be modified after construction.');
    }
}
