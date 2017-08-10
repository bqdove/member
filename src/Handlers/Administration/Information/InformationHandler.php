<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-21 18:19
 */
namespace Notadd\Member\Handlers\Administration\Information;

use Illuminate\Support\Collection;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Validation\Rule;
use Notadd\Member\Models\MemberInformation;
use Notadd\Member\Models\MemberInformationGroup;

/**
 * Class InformationHandler.
 */
class InformationHandler extends Handler
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
                Rule::exists('member_informations'),
                Rule::numeric(),
                Rule::required(),
            ],
        ], [
            'id.exists'   => '没有对应的信息项信息',
            'id.numeric'  => '信息项 ID 必须为数值',
            'id.required' => '信息项 ID　必须填写',
        ]);
        $builder = MemberInformation::query();
        $builder->with('groups');
        $information = $builder->find($this->request->input('id'));
        if ($information instanceof MemberInformation) {
            $exists = $information->getRelation('groups');
            $exists instanceof Collection && $exists = $exists->keyBy('id');
            $groups = MemberInformationGroup::all();
            $groups->transform(function (MemberInformationGroup $group) use ($exists) {
                if ($exists->has($group->getAttribute('id'))) {
                    $group->setAttribute('exists', true);
                } else {
                    $group->setAttribute('exists', false);
                }
                return $group;
            });
            $this->withCode(200)->withData($information)->withExtra([
                'groups' => $groups->toArray(),
            ])->withMessage('获取信息项信息成功！');
        } else {
            $this->withCode(500)->withError('获取信息项信息失败！');
        }
    }
}
