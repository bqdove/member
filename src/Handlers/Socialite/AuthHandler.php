<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-06 21:11
 */

namespace Notadd\Member\Handlers\Socialite;

use Notadd\Foundation\Routing\Abstracts\Handler;

/**
 * Class AuthHandler.
 */
class AuthHandler extends Handler
{
    /**
     * @var string
     */
    protected $driver;

    /**
     * @param string $driver
     *
     * @return $this
     */
    public function withDriver(string $driver)
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        // TODO: Implement execute() method.
    }
}
