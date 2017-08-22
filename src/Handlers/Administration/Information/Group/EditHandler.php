<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-04 19:14
 */
namespace Notadd\Member\Handlers\Administration\Information\Group;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Validation\Rule;
use Notadd\Member\Models\MemberInformationGroup;

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
    protected function execute()
    {
        $this->validate($this->request, [
            'id'    => [
                Rule::exists('member_information_groups'),
                Rule::numeric(),
                Rule::required(),
            ],
            'name'  => Rule::required(),
            'order' => Rule::numeric(),
            'show'  => Rule::boolean(),
        ], [
            'id.exists'     => '没有对应的信息分组信息',
            'id.numeric'    => '信息分组 ID 必须为数值',
            'id.required'   => '信息分组 ID 必须填写',
            'name.required' => '分组名称必须填写',
            'order.numeric' => '排序必须为数值',
            'show.boolean'  => '前台显示必须为布尔值',
        ]);
        $this->beginTransaction();
        $group = MemberInformationGroup::query()->find($this->request->input('id'));
        $data = $this->request->only([
            'name',
            'order',
            'show',
        ]);
        if ($group instanceof MemberInformationGroup) {
            $group->update($data);
            $group->informations()->sync((array)$this->request->input('informations'));
            $this->commitTransaction();
            $this->withCode(200)->withMessage('编辑信息分组信息成功！');
        } else {
            $this->rollBackTransaction();
            $this->withCode(500)->withError('编辑信息分组信息失败！');
        }
    }
}
