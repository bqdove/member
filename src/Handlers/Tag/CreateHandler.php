<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-04-21 18:22
 */
namespace Notadd\Member\Handlers\Tag;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Notadd\Foundation\Passport\Abstracts\SetHandler;
use Notadd\Member\Models\MemberTag;

/**
 * Class CreateHandler.
 */
class CreateHandler extends SetHandler
{
    /**
     * Execute Handler.
     *
     * @return bool
     * @throws \Exception
     */
    public function execute()
    {
        $this->validate($this->request, [
            'tag' => 'required',
        ], [
            'tag.required' => $this->translator->trans('必须填写标签名称！'),
        ]);
        $created = new Collection();
        $tags = new Collection();
        if (Str::contains($this->request->input('tag'), ',')) {
            foreach (explode(',', $this->request->input('tag')) as $tag) {
                $tags->push($tag);
            }
        } else {
            $tags->push($this->request->input('tag'));
        }
        $tags->each(function (string $tag) use ($created) {
            if (MemberTag::query()->where('tag', $tag)->count()) {
                $created->push(MemberTag::query()->where('tag', $tag)->first());
            } else {
                $created->push(MemberTag::query()->create([
                    'tag' => $tag,
                ]));
            }
        });
        if ($users = $this->request->input('users')) {
            $users = explode(PHP_EOL, $users);
        }

        $this->messages->push($this->translator->trans('创建用户标签成功！'));

        return true;
    }
}
