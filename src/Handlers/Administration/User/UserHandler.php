<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-21 16:38
 */
namespace Notadd\Member\Handlers\Administration\User;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Notadd\Foundation\Database\Model;
use Notadd\Foundation\Member\Member;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Validation\Rule;
use Notadd\Member\Models\MemberGroup;
use Notadd\Member\Models\MemberGroupRelation;
use Notadd\Member\Models\MemberInformation;
use Notadd\Member\Models\MemberInformationGroup;
use Notadd\Member\Models\MemberInformationValue;

/**
 * Class UserHandler.
 */
class UserHandler extends Handler
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
                Rule::exists('members'),
                Rule::numeric(),
                Rule::required(),
            ],
        ], [
            'id.exists'   => '没有对应的用户信息',
            'id.numeric'  => '用户 ID 必须是数值',
            'id.required' => '用户 ID 必须填写',
        ]);
        $builder = Member::query();
        foreach ((array)$this->request->input('with', []) as $with) {
            $builder = $builder->with($with);
        }
        $user = $builder->find($this->request->input('id'));
        $builder = MemberInformationGroup::query();
        $builder->with(['informations' => function (BelongsToMany $builder) {
            $builder->with(['values' => function (HasMany $builder) {
                $builder->where('member_id', $this->request->input('id'));
            }]);
            $builder->get([
                'description',
                'details',
                'id',
                'length',
                'name',
                'order',
                'opinions',
                'required',
                'type',
            ]);
        }]);
        $informations = $builder->orderBy('order', 'asc')->get();
        if ($user instanceof Model) {
            $groups = $user->getAttribute('groups');
            if ($groups instanceof Collection) {
                $groups->transform(function (MemberGroup $group) use ($user) {
                    $relation = MemberGroupRelation::query()
                        ->where('group_id', $group->getAttribute('id'))
                        ->where('member_id', $user->getAttribute('id'))
                        ->first();
                    if ($relation instanceof Model) {
                        $group->setAttribute('end', $relation->getAttribute('end'));
                        $group->setAttribute('next', $relation->getAttribute('next'));
                        $group->setAttribute('type', $relation->getAttribute('type'));
                    }

                    return $group;
                });
            }
            $user->setAttribute('groups', $groups);
            $this->withCode(200)->withData($user)->withExtra([
                'informations' => $informations->transform(function (MemberInformationGroup $group) {
                    $informations = $group->getRelation('informations');
                    $informations instanceof Collection && $informations->transform(function (MemberInformation $information) {
                        switch ($information->getAttribute('type')) {
                            case 'radio':
                                $information->setAttribute('opinions', explode(PHP_EOL, $information->getAttribute('opinions')));
                                break;
                        }
                        $value = $information->getRelation('values')->first();
                        $information->setAttribute('value', $value instanceof MemberInformationValue ? $value->getAttribute('value') : '');

                        return $information;
                    });
                    $group->setRelation('informations', $informations);

                    return $group;
                }),
            ])->withMessage('获取用户信息成功！');
        } else {
            $this->withCode(500)->withError('获取用户信息失败！');
        }
    }
}
