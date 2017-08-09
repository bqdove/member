<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-21 17:42
 */
namespace Notadd\Member\Handlers\Administration\Group;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Validation\Rule;
use Notadd\Member\Models\MemberGroup;

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
        $builder = MemberGroup::query();
        $builder->with('members');
        $builder->withCount('members');
        if ($without = $this->request->input('without')) {
            if (is_array($without)) {
                $builder = $builder->whereNotIn('id', $without);
            } else {
                $builder = $builder->where('id', '!=', $without);
            }
        }
        $builder->orderBy($this->request->input('sort', 'created_at'), $this->request->input('order', 'desc'));
        $pagination = $builder->paginate($this->request->input('paginate', 20));
        $this->withCode(200)->withData($pagination->items())->withMessage('')->withExtra([
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
}
