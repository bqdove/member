<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-03-10 14:12
 */

namespace Notadd\Member\Injections;

use Notadd\Foundation\Module\Abstracts\Installer as AbstractInstaller;
use Notadd\Member\Models\MemberGroup;
use Notadd\Member\Models\MemberGroupRelation;

/**
 * Class Installer.
 */
class Installer extends AbstractInstaller
{
    /**
     * @return bool
     */
    public function handle()
    {
        return true;
    }

    /**
     * Post handle.
     */
    public function post()
    {
        MemberGroup::query()->create([
            'identification' => 'admin',
            'name' => '管理员组',
        ]);
        MemberGroup::query()->create([
            'identification' => 'user',
            'name' => '用户组组',
        ]);
        MemberGroupRelation::query()->create([
            'group_id' => 1,
            'member_id' => 1,
        ]);
    }

    /**
     * @return array
     */
    public function require()
    {
        return [];
    }
}
