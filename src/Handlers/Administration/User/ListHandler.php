<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-21 15:18
 */
namespace Notadd\Member\Handlers\Administration\User;

use Illuminate\Container\Container;
use Notadd\Foundation\Member\Member;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Validation\Rule;
use Notadd\Member\Models\MemberGroup;
use Notadd\Member\Models\MemberGroupRelation;

/**
 * Class ListHandler.
 */
class ListHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $this->validate($this->request, [
            'order'    => Rule::in([
                'asc',
                'desc',
            ]),
            'page'     => Rule::numeric(),
            'paginate' => Rule::numeric(),
        ], [
            'order.in'         => '排序规则错误',
            'page.numeric'     => '当前页面必须为数值',
            'paginate.numeric' => '分页数必须为数值',
        ]);
        $builder = Member::query();
        if ($withs = $this->request->input('with', [])) {
            foreach ((array)$withs as $with) {
                $builder = $builder->with($with);
            }
        }
        if ($this->request->has('search')) {
            $builder = $builder->where('name', 'like', "%{$this->request->input('search')}%");
        }
        $builder->orderBy($this->request->input('sort', 'created_at'), $this->request->input('order', 'desc'));
        $pagination = $builder->paginate($this->request->input('paginate', 20));
        $data = [];
        switch ($this->request->input('format', 'raw')) {
            case 'raw':
                $data = $pagination->items();
                break;
            case 'beauty':
                $data = $this->format($pagination->items());
                break;
        }
        $this->withCode(200)->withData($data)->withMessage('')->withExtra([
            'pagination' => [
                'count'    => $pagination->total(),
                'current'  => $pagination->currentPage(),
                'from'     => $pagination->firstItem(),
                'next'     => $pagination->nextPageUrl(),
                'prev'     => $pagination->previousPageUrl(),
                'to'       => $pagination->lastItem(),
                'total'    => $pagination->lastPage(),
            ],
        ]);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function format(array $data)
    {
        return collect($data)->transform(function (Member $member) {
            switch ($member->getAttribute('status')) {
                case 'normal':
                    $member->setAttribute('status', '正常');
                    break;
            }
            $groups = collect($member->getAttribute('groups'));
            if ($groups->count()) {
                $groups->each(function (MemberGroup $group) use ($member) {
                    $relation = MemberGroupRelation::query()->where('group_id', $group->getAttribute('id'))->where('member_id', $member->getAttribute('id'))->first();
                    if ($relation->getAttribute('type') == 'default') {
                        $member->setAttribute('group', $group->getAttribute('name'));
                    }
                });
            } else {
                $member->setAttribute('group', '');
            }

            return $member;
        })->toArray();
    }
}
