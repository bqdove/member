<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-27 18:07
 */
namespace Notadd\Member\Handlers\Administration\User;

use Carbon\Carbon;
use Illuminate\Container\Container;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Validation\Rule;
use Notadd\Member\Models\MemberGroupRelation;

/**
 * Class GroupHandler.
 */
class GroupHandler extends Handler
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $exits;

    /**
     * @var \Notadd\Member\Models\MemberGroup
     */
    protected $group;

    /**
     * @var \Notadd\Member\Models\MemberGroupRelation
     */
    protected $memberGroup;

    /**
     * @var \Illuminate\Support\Collection
     */
    private $groups;

    /**
     * GroupHandler constructor.
     *
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->groups = collect();
    }

    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    public function execute()
    {
        $this->validate($this->request, [
            'member_id' => [
                Rule::exists('members', 'id'),
                Rule::numeric(),
                Rule::required(),
            ],
        ], [
            'member_id.exists'   => '没有对应的用户信息',
            'member_id.numeric'  => '用户 ID 必须为数值',
            'member_id.required' => '用户 ID 必须填写',
        ]);
        $this->beginTransaction();
        $builder = MemberGroupRelation::query();
        $builder->with('group');
        $builder->with('member');
        $builder->where('member_id', $this->request->input('member_id'));
        $exits = $builder->get()->keyBy('group_id');
        collect($this->request->input('data'))->each(function ($data) use ($exits) {
            $groupId = $data['group_id'];
            if ($data['end']) {
                $data['end'] = Carbon::createFromTimestamp(strtotime($data['end']));
            } else {
                unset($data['end']);
            }
            if ($exits->has($data['group_id'])) {
                $exits->get($groupId)->update($data);
                $exits->pull($groupId);
            } else {
                MemberGroupRelation::query()->create($data);
            }
        });
        $exits->each(function (MemberGroupRelation $group) {
            $group->delete();
        });
        $this->commitTransaction();
        $this->withCode(200)->withMessage('更新用户用户组信息成功！');
    }
}
