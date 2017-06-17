<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-31 20:44
 */
namespace Notadd\Member\Listeners;

use Notadd\Foundation\Flow\Abstracts\FlowRegister as AbstractFlowRegister;
use Notadd\Member\Flows\Member;
use Notadd\Member\Flows\MemberBan;
use Notadd\Member\Flows\MemberGroup;
use Notadd\Member\Flows\MemberInformation;
use Notadd\Member\Flows\MemberNotification;
use Notadd\Member\Flows\MemberPermission;
use Notadd\Member\Flows\MemberTag;
use Notadd\Member\Flows\MemberVerification;

/**
 * Class FlowRegister.
 */
class FlowRegister extends AbstractFlowRegister
{
    /**
     * Register flow or flows.
     */
    public function handle()
    {
        $this->flow->register(Member::class);
        $this->flow->register(MemberBan::class);
        $this->flow->register(MemberGroup::class);
        $this->flow->register(MemberInformation::class);
        $this->flow->register(MemberNotification::class);
        $this->flow->register(MemberPermission::class);
        $this->flow->register(MemberTag::class);
        $this->flow->register(MemberVerification::class);
    }
}
