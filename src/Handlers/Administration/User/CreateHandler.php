<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-21 17:13
 */
namespace Notadd\Member\Handlers\Administration\User;

use Notadd\Foundation\Member\Member;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Member\Models\MemberInformation;

/**
 * Class Create.
 */
class CreateHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    public function execute()
    {
        $this->validate($this->request, [
            'email'    => 'required|email',
            'name'     => 'required',
            'password' => 'required',
        ], [
            'email.required'    => $this->translator->trans('必须填写电子邮箱账号！'),
            'email.email'       => $this->translator->trans('请填写格式正确的电子邮箱账号！'),
            'name.required'     => $this->translator->trans('必须填写用户名！'),
            'password.required' => $this->translator->trans('必须填写密码！'),
        ]);
        $this->beginTransaction();
        $this->request->offsetSet('password', bcrypt($this->request->input('password')));
        $data = $this->request->only([
            'email',
            'name',
            'password',
        ]);
        $informations = collect($this->request->input('informations'));
        $member = Member::query()->create($data);
        if ($member instanceof Member && $informations->every(function ($data) use ($member) {
                $information = MemberInformation::query()->with('values')->find($data['id']);
                if ($information instanceof MemberInformation && $information->getAttribute('type') == $data['type']) {
                    $information->values()->updateOrCreate([
                        'information_id' => $data['id'],
                        'member_id'      => $member->getAttribute('id'),
                    ], [
                        'value' => $data['value'],
                    ]);

                    return true;
                } else {
                    return false;
                }
            })) {
            $this->commitTransaction();
            $this->withCode(200)->withMessage('创建用户成功！');
        } else {
            $this->rollBackTransaction();
            $this->withCode(500)->withError('创建用户失败！');
        }
    }
}
