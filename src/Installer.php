<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-24 20:58
 */
namespace Notadd\Member;

use Illuminate\Container\Container;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;
use Notadd\Member\Models\MemberGroup;
use Notadd\Member\Models\MemberGroupRelation;

/**
 * Class Installer.
 */
class Installer implements \Notadd\Foundation\Module\Contracts\Installer
{
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * Installer constructor.
     *
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Handler install.
     *
     * @return true
     */
    public function install()
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

        return true;
    }
}
