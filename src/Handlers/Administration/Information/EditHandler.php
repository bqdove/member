<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-21 18:14
 */
namespace Notadd\Member\Handlers\Administration\Information;

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
            'id'     => [
                Rule::exists('member_informations'),
                Rule::numeric(),
                Rule::required(),
            ],
            'groups' => Rule::array(),
            'name'   => Rule::required(),
        ], [
            'id.exists'     => '没有对应的信息项信息',
            'id.numeric'    => '信息项 ID 必须为数值',
            'id.required'   => '信息项 ID 必须填写',
            'name.required' => '信息项名称必须填写',
        ]);
        $this->beginTransaction();
        $builder = MemberInformation::query();
        $builder->with('groups');
        $information = $builder->find($this->request->input('id'));
        $data = $this->request->only([
            'description',
            'details',
            'length',
            'name',
            'order',
            'opinions',
            'privacy',
            'register',
            'required',
            'type',
        ]);
        if ($information instanceof MemberInformation) {
            $information->update($data);
            $information->groups()->sync((array)$this->request->input('groups'));
            $this->commitTransaction();
            $this->withCode(200)->withMessage('更新信息项数据成功！');
        } else {
            $this->rollBackTransaction();
            $this->withCode(500)->withError('更新信息项数据失败！');
        }
    }
}
