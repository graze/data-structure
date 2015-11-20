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

namespace Graze\DataStructure\Exception;

use Exception;
use OutOfBoundsException;

class RegisteredKeyException extends OutOfBoundsException
{
    /**
     * @param string $key
     * @param Exception $previous
     */
    public function __construct($key, Exception $previous = null)
    {
        parent::__construct(sprintf('Value with key "%s" is already registered', $key), 0, $previous);
    }
}
