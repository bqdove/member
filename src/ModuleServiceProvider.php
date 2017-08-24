<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-14 13:49
 */
namespace Notadd\Member;

use Notadd\Foundation\Member\Member;
use Notadd\Member\Injections\Installer;
use Notadd\Member\Injections\Uninstaller;
use Notadd\Foundation\Member\MemberManagement;
use Notadd\Foundation\Module\Abstracts\Module;
use Notadd\Member\Models\MemberActivate;
use Notadd\Member\Models\MemberBan;
use Notadd\Member\Models\MemberGroup;

/**
 * Class Extension.
 */
class ModuleServiceProvider extends Module
{
    /**
     * Boot service provider.
     */
    public function boot()
    {
        Member::macro('activate', function () {
            return $this->hasOne(MemberActivate::class, 'member_id');
        });
        Member::macro('ban', function () {
            return $this->hasOne(MemberBan::class, 'member_id');
        });
        Member::macro('groups', function () {
            return $this->belongsToMany(MemberGroup::class, 'member_group_relations', 'member_id', 'group_id');
        });
        $manager = new Manager($this->app['events'], $this->app['router']);
        $this->app->make(MemberManagement::class)->registerManager($manager);
        $this->loadViewsFrom(realpath(__DIR__ . '/../resources/views'), 'member');
        $this->loadTranslationsFrom(realpath(__DIR__ . '/../resources/translations'), 'member');
    }

    /**
     * Register module extra providers.
     */
    public function register()
    {
        $this->app->singleton('integral', function ($app) {
            return new IntegralManager($app);
        });
        $this->app->singleton('socialite', function ($app) {
            return new SocialiteManager($app);
        });
    }
}
