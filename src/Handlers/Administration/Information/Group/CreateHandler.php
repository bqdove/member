<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-04 19:02
 */
namespace Notadd\Member\Handlers\Administration\Information\Group;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Validation\Rule;
use Notadd\Member\Models\MemberInformationGroup;

/**
 * Class CreateHandler.
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
            'name'  => Rule::required(),
            'order' => Rule::numeric(),
            'show'  => Rule::boolean(),
        ], [
            'name.required' => '分组名称必须填写',
            'order.numeric' => '排序必须为数值',
            'show.boolean'  => '前台显示必须为布尔值',
        ]);
        $this->beginTransaction();
        $data = $this->request->only([
            'name',
            'order',
            'show',
        ]);
        if (MemberInformationGroup::query()->create($data)) {
            $this->commitTransaction();
            $this->withCode(200)->withMessage('创建信息分组成功！');
        } else {
            $this->rollBackTransaction();
            $this->withCode(500)->withError('创建信息分组失败！');
        }
    }
}
