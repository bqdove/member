<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-06-01 18:47
 */
namespace Notadd\Member\Flows;

use Notadd\Foundation\Flow\Abstracts\Entity;
use Symfony\Component\Workflow\Event\GuardEvent;
use Symfony\Component\Workflow\Transition;

/**
 * Class Member.
 */
class Member extends Entity
{
    /**
     * @return array
     */
    public function events()
    {
        return [];
    }

    /**
     * @return string
     */
    public function name()
    {
        return 'member.member';
    }

    /**
     * @return array
     */
    public function places()
    {
        return [
            'register',
            'registered',
            'validate',
            'validated',
        ];
    }

    /**
     * @return array
     */
    public function transitions()
    {
        return [
            new Transition('register', 'register', 'registered'),
            new Transition('wait_to_validate', 'registered', 'validate'),
            new Transition('validate', 'validate', 'validated'),
        ];
    }

    /**
     * Guard a transition.
     *
     * @param \Symfony\Component\Workflow\Event\GuardEvent $event
     */
    public function guard(GuardEvent $event)
    {
        // TODO: Implement guard() method.
    }
}
