<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-08 10:45
 */

namespace Notadd\Member\Contracts;

/**
 * Interface AccessToken.
 */

interface AccessToken
{
    /**
     * Return the access token string.
     *
     * @return string
     */
    public function getToken();
}
