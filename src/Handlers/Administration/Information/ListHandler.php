<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-21 18:15
 */
namespace Notadd\Member\Handlers\Administration\Information;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Validation\Rule;
use Notadd\Member\Models\MemberInformation;

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
        $builder = MemberInformation::query();
        if ($withs = $this->request->input('with', [])) {
            foreach ((array)$withs as $with) {
                $builder = $builder->with($with);
            }
        }
        $builder->orderBy($this->request->input('sort', 'order'), $this->request->input('order', 'desc'));
        if ($this->request->input('paginate') === 0) {
            $this->withCode(200)->withData($builder->get())->withMessage('获取分类信息项列表成功！');
        } else {
            $pagination = $builder->paginate($this->request->input('paginate', 20));
            $this->withCode(200)->withData($pagination->items())->withMessage('获取分类信息项列表成功！')->withExtra([
                'pagination' => [
                    'count'    => $pagination->total(),
                    'current'  => $pagination->currentPage(),
                    'from'     => $pagination->firstItem(),
                    'next'     => $pagination->nextPageUrl(),
                    'paginate' => $this->request->input('paginate', 20),
                    'prev'     => $pagination->previousPageUrl(),
                    'to'       => $pagination->lastItem(),
                    'total'    => $pagination->lastPage(),
                ],
            ]);
        }
    }
}
