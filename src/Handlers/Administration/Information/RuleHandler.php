<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-12 03:43
 */

namespace Notadd\Member\Handlers\Administration\Information;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Member\Models\MemberInformation;
use Notadd\Member\Models\MemberInformationGroup;

/**
 * Class RuleHandler.
 */
class RuleHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
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
        $builder->orderBy('order', 'asc');
        $extras = $builder->get()->transform(function (MemberInformationGroup $group) {
            $informations = $group->getRelation('informations');
            $informations instanceof Collection && $informations->transform(function (MemberInformation $information) {
                switch ($information->getAttribute('type')) {
                    case 'radio':
                        $information->setAttribute('opinions', explode(PHP_EOL, $information->getAttribute('opinions')));
                        break;
                }
                $information->setAttribute('value', '');

                return $information;
            });
            $group->setRelation('informations', $informations);

            return $group;
        });
        $this->withCode(200)->withData([
            'extras'       => $extras,
            'informations' => $extras->pluck('informations')->collapse()->keyBy('id')->transform(function (MemberInformation $information) {
                $rules = [];
                if ($information->getAttribute('required')) {
                    $rules['required'] = true;
                    $rules['message'] = '请输入' . $information->getAttribute('name');
                    $rules['trigger'] = 'change';
                    if (in_array($information->getAttribute('type'), ['date', 'datetime'])) {
                        $rules['type'] = 'date';
                    } else {
                        $rules['type'] = 'string';
                    }
                }
                $information->setAttribute('rules', $rules);

                return $information;
            }),
        ])->withMessage('');
    }
}
