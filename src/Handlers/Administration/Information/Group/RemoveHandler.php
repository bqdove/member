<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-04 19:17
 */
namespace Notadd\Member\Handlers\Administration\Information\Group;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Validation\Rule;
use Notadd\Member\Models\MemberInformationGroup;

/**
 * Class RemoveHandler.
 */
class RemoveHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    public function execute()
    {
        $this->validate($this->request, [
            'id' => [
                Rule::exists('member_information_groups'),
                Rule::numeric(),
                Rule::required(),
            ],
        ], [
            'id.exists'   => '没有对应的信息分组信息',
            'id.numeric'  => '信息分组 ID 必须为数值',
            'id.required' => '信息分组 ID 必须填写',
        ]);
        $this->beginTransaction();
        $group = MemberInformationGroup::query()->find($this->request->input('id'));
        if ($group instanceof MemberInformationGroup && $group->delete()) {
            $this->commitTransaction();
            $this->withCode(200)->withMessage('删除信息分组成功！');
        } else {
            $this->rollBackTransaction();
            $this->withCode(500)->withError('删除信息分组失败！');
        }
    }
}
