<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-06 21:11
 */

namespace Notadd\Member\Handlers\Socialite;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Str;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Member\Models\SocialiteAuth;

/**
 * Class AuthHandler.
 */
class AuthHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $socialite = $this->authentic();
        $this->withCode(200)->withData($socialite->getAuthUrl())->withMessage('获取认证链接成功！');
    }

    /**
     * @return \Notadd\Member\Abstracts\Driver
     */
    public function authentic()
    {
        $driver = $this->request->route('driver');
        $socialite = $this->container->make('socialite')->with($driver);
        $socialite->withState(md5(Str::random(10) . time() . Str::random(10)));
        $socialite->withRedirectUrl($this->container->make(UrlGenerator::class)->to("socialite/{$driver}/token"));
        SocialiteAuth::query()->updateOrCreate([
            'state' => $socialite->getState(),
            'type'  => $driver,
        ]);

        return $socialite;
    }
}
