<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-06 02:24
 */
namespace Notadd\Member;

use InvalidArgumentException;
use Notadd\Foundation\Http\Supports\Manager;

/**
 * Class SocialiteManager.
 */
class SocialiteManager extends Manager
{
    /**
     * @param array $configuration
     *
     * @return array
     */
    public function formatCongiuration(array $configuration)
    {
        return array_merge([
            'identifier' => $configuration['client_id'],
            'secret' => $configuration['client_secret'],
            'callback_uri' => $configuration['redirect'],
        ], $configuration);
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        throw new InvalidArgumentException('No Socialite driver was specified.');
    }

    /**
     * @param $driver
     *
     * @return mixed
     */
    public function with($driver)
    {
        return $this->driver($driver);
    }
}
