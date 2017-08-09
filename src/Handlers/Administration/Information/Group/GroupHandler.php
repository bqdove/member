<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-09 20:28
 */

namespace Notadd\Member\Handlers\Administration\Information\Group;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Validation\Rule;
use Notadd\Member\Models\MemberInformationGroup;

/**
 * Class GroupHandler.
 */
class GroupHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
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
        $builder = MemberInformationGroup::query();
        $builder->with('informations');
        $this->withCode(200)->withData($builder->find($this->request->input('id')))->withMessage('获取信息分组信息成功！');
    }
}