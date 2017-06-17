<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-21 16:38
 */
namespace Notadd\Member\Handlers\User;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Notadd\Foundation\Database\Model;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Member\Member;
use Notadd\Member\Models\MemberGroup;
use Notadd\Member\Models\MemberGroupRelation;

/**
 * Class UserHandler.
 */
class UserHandler extends Handler
{
    /**
     * @var string
     */
    protected $format;

    /**
     * @var int
     */
    protected $id;

    /**
     * UserHandler constructor.
     *
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->format = 'raw';
        $this->id = 1;
    }

    /**
     * @throws \Exception
     */
    public function configurations()
    {
        $this->format = $this->request->input('format') ?: $this->format;
        $this->id = $this->request->input('id') ?: $this->id;
        if (!$this->id) {
            throw new \Exception('Id is not setted!');
        }
    }

    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $this->configurations();
        $builder = Member::query();
        $builder = $builder->where('id', $this->id);
        if ($withs = $this->request->input('with')) {
            foreach ((array)$withs as $with) {
                $builder = $builder->with($with);
            }
        }
        $user = $builder->first();
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
            $this->withCode(200)->withData($user->toArray())->withMessage('');
        } else {
            $this->withCode(500)->withError('');
        }
    }
}
