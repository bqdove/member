<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-21 17:22
 */
namespace Notadd\Member\Handlers\Administration\User;

use Notadd\Foundation\Member\Member;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Validation\Rule;
use Notadd\Member\Models\MemberInformation;

/**
 * Class EditHandler.
 */
class EditHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    public function execute()
    {
        $this->validate($this->request, [
            'email' => [
                Rule::email(),
                Rule::required(),
            ],
            'id'    => [
                Rule::exists('members'),
                Rule::numeric(),
                Rule::required(),
            ],
            'name'  => Rule::required(),
        ], [
            'email.required' => '电子邮箱必须填写',
            'email.email'    => '电子邮箱格式不正确',
            'id.exists'      => '没有对应的用户信息',
            'id.numeric'     => '用户 ID 必须为数值',
            'id.required'    => '用户 ID 必须填写',
            'name.required'  => '用户名必须填写',
        ]);
        $this->beginTransaction();
        $member = Member::query()->find($this->request->input('id'));
        $data = $this->request->only([
            'email',
            'name',
        ]);
        if ($member instanceof Member) {
            $member->update($data);
            $groups = collect($this->request->input('informations'))->pluck('informations');
            $groups->collapse()->keyBy('id')->unique()->each(function ($data) {
                $information = MemberInformation::query()->with('values')->find($data['id']);
                if ($information instanceof MemberInformation && $information->getAttribute('type') == $data['type']) {
                    $information->values()->updateOrCreate([
                        'information_id' => $data['id'],
                        'member_id'      => $this->request->input('id'),
                    ], [
                        'value' => $data['value'],
                    ]);
                }
            });
            $this->commitTransaction();
            $this->withCode(200)->withMessage('更新用户信息成功！');
        } else {
            $this->rollBackTransaction();
            $this->withCode(500)->withError('更新用户信息失败！');
        }
    }
}
