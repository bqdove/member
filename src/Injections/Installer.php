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
use Notadd\Foundation\Setting\Contracts\SettingsRepository;
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
     * @return array
     */
    public function require()
    {
        return [];
    }

    /**
     * Post handle.
     */
    public function post()
    {
        MemberGroup::query()->create([
            'identification' => 'admin',
            'name'           => '管理员组',
        ]);
        MemberGroup::query()->create([
            'identification' => 'user',
            'name'           => '用户组组',
        ]);
        MemberGroupRelation::query()->create([
            'group_id'  => 1,
            'member_id' => 1,
        ]);
        $this->container->make(SettingsRepository::class)->set('permissions', json_encode([
            'global::global::attachment::attachment.manage' => ['admin'],
            'global::global::debug::debug.manage'           => ['admin'],
            'global::global::extension::extension.manage'   => ['admin'],
            'global::global::mail::mail.manage'             => ['admin'],
            'global::global::module::module.manage'         => ['admin'],
            'global::global::search-engine::seo.get'        => ['admin'],
            'global::global::search-engine::seo.set'        => ['admin'],
            'global::global::global::setting.get'           => ['admin'],
            'global::global::global::setting.set'           => ['admin'],
            'global::administration::global::entry'         => ['admin'],
        ]));
    }
}
