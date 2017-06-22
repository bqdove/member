<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-04 16:00
 */
namespace Notadd\Member\Models;

use Notadd\Foundation\Database\Model;
use Notadd\Foundation\Database\Traits\HasFlow;
use Symfony\Component\Workflow\Event\GuardEvent;

/**
 * Class MemberTag.
 */
class MemberTag extends Model
{
    use HasFlow;

    /**
     * @var array
     */
    protected $fillable = [
        'flow_marketing',
        'tag',
    ];

    /**
     * @var string
     */
    protected $table = 'member_tags';

    /**
     * Definition of name for flow.
     *
     * @return string
     */
    public function name()
    {
        return 'member.tag';
    }

    /**
     * Definition of places for flow.
     *
     * @return array
     */
    public function places()
    {
        return [];
    }

    /**
     * Definition of transitions for flow.
     *
     * @return array
     */
    public function transitions()
    {
        return [];
    }

    /**
     * Guard a transition.
     *
     * @param \Symfony\Component\Workflow\Event\GuardEvent $event
     */
    public function guardTransition(GuardEvent $event)
    {
        // TODO: Implement guardTransition() method.
    }
}
