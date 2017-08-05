<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-06 02:24
 */
namespace Notadd\Member;

use Notadd\Foundation\Http\Supports\Manager;

/**
 * Class SocialiteManager.
 */
class SocialiteManager extends Manager
{
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return '';
    }
}
