<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-07 21:45
 */

namespace Notadd\Member\Handlers\Socialite;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Member\Models\SocialiteAuth;

/**
 * Class TokenHandler.
 */
class TokenHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $info = $this->tokenize();
        if ($info === false) {
            $this->withCode(500)->withError('授权失败！');
        } else {
            $this->withCode(200)->withData($info)->withMessage('授权成功！');
        }
    }

    /**
     * @return bool|\Illuminate\Support\Collection
     */
    public function tokenize()
    {
        $socialite = $this->container->make('socialite')->with($this->request->route('driver'));
        $token = $socialite->getAccessToken($this->request->query('code'));
        $info = $socialite->user($token);
        $this->beginTransaction();
        $builder = SocialiteAuth::query();
        $builder->where('type', $this->request->route('driver'));
        $builder->where('state', $this->request->query('state'));
        if ($builder->count()) {
            $existWithState = $builder->first();
            $builder = SocialiteAuth::query();
            $builder->where('type', $this->request->route('driver'));
            $builder->where('identification', $info->get($socialite->getIdentification()));
            if ($builder->count()) {
                $data = [
                    'extra' => json_encode($info->except('identification')),
                ];
                $existWithIdentification = $builder->first();
                $existWithIdentification->update($data);
                $existWithState->delete();
            } else {
                $data = [
                    'extra'          => json_encode($info->except('identification')),
                    'identification' => $info->get($socialite->getIdentification()),
                ];
                $existWithState->update($data);
            }
            $this->commitTransaction();

            return $info;
        } else {
            return false;
        }
    }
}
