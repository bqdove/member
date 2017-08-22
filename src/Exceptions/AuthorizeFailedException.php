<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-06 04:05
 */

namespace Notadd\Member\Exceptions;

use RuntimeException;

/**
 * Class AuthorizeFailedException.
 */
class AuthorizeFailedException extends RuntimeException
{
    /**
     * Response body.
     *
     * @var array
     */
    public $body;

    /**
     * Constructor.
     *
     * @param string $message
     * @param string $body
     */
    public function __construct($message, $body)
    {
        parent::__construct($message, -1);

        $this->body = $body;
    }

}
