<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-14 13:56
 */
namespace Notadd\Member\Listeners;

use Notadd\Foundation\Routing\Abstracts\RouteRegister as AbstractRouteRegister;
use Notadd\Member\Controllers\Api\Administration\BanController as BanControllerForAdministration;
use Notadd\Member\Controllers\Api\Administration\GroupController as GroupControllerForAdministration;
use Notadd\Member\Controllers\Api\Administration\InformationController as InformationControllerForAdministration;
use Notadd\Member\Controllers\Api\Administration\InformationGroupController as InformationGroupControllerForAdministration;
use Notadd\Member\Controllers\Api\Administration\NotificationController as NotificationControllerForAdministration;
use Notadd\Member\Controllers\Api\Administration\PermissionController as PermissionControllerForAdministration;
use Notadd\Member\Controllers\Api\Administration\TagController as TagControllerForAdministration;
use Notadd\Member\Controllers\Api\Administration\UploadController as UploadControllerForAdministration;
use Notadd\Member\Controllers\Api\Administration\UserController as UserControllerForAdministration;
use Notadd\Member\Controllers\Api\Administration\VerificationController as VerificationControllerForAdministration;
use Notadd\Member\Controllers\Api\User\UserController as UserControllerForUser;

/**
 * Class RouteRegister.
 */
class RouteRegister extends AbstractRouteRegister
{
    /**
     * Handle Route Register.
     */
    public function handle()
    {
        $this->router->group(['middleware' => ['auth:api', 'cross', 'web'], 'prefix' => 'api/member/administration'], function () {
            $this->router->post('ban/create', BanControllerForAdministration::class . '@create');
            $this->router->post('ban/ip', BanControllerForAdministration::class . '@ip');
            $this->router->post('ban/list', BanControllerForAdministration::class . '@list');
            $this->router->post('ban/remove', BanControllerForAdministration::class . '@remove');
            $this->router->post('group', GroupControllerForAdministration::class . '@group');
            $this->router->post('group/create', GroupControllerForAdministration::class . '@create');
            $this->router->post('group/edit', GroupControllerForAdministration::class . '@edit');
            $this->router->post('group/list', GroupControllerForAdministration::class . '@list');
            $this->router->post('group/remove', GroupControllerForAdministration::class . '@remove');
            $this->router->post('information', InformationControllerForAdministration::class . '@information');
            $this->router->post('information/create', InformationControllerForAdministration::class . '@create');
            $this->router->post('information/edit', InformationControllerForAdministration::class . '@edit');
            $this->router->post('information/list', InformationControllerForAdministration::class . '@list');
            $this->router->post('information/patch', InformationControllerForAdministration::class . '@patch');
            $this->router->post('information/remove', InformationControllerForAdministration::class . '@remove');
            $this->router->post('information/group/create', InformationGroupControllerForAdministration::class . '@create');
            $this->router->post('information/group/edit', InformationGroupControllerForAdministration::class . '@edit');
            $this->router->post('information/group/list', InformationGroupControllerForAdministration::class . '@list');
            $this->router->post('information/group/patch', InformationGroupControllerForAdministration::class . '@patch');
            $this->router->post('information/group/remove', InformationGroupControllerForAdministration::class . '@remove');
            $this->router->post('notification', NotificationControllerForAdministration::class . '@notification');
            $this->router->post('notification/create', NotificationControllerForAdministration::class . '@create');
            $this->router->post('notification/edit', NotificationControllerForAdministration::class . '@edit');
            $this->router->post('notification/list', NotificationControllerForAdministration::class . '@list');
            $this->router->post('notification/remove', NotificationControllerForAdministration::class . '@remove');
            $this->router->post('notification/send', NotificationControllerForAdministration::class . '@send');
            $this->router->post('permission/get', PermissionControllerForAdministration::class . '@get');
            $this->router->post('permission/set', PermissionControllerForAdministration::class . '@set');
            $this->router->post('tag', TagControllerForAdministration::class . '@tag');
            $this->router->post('tag/create', TagControllerForAdministration::class . '@create');
            $this->router->post('tag/edit', TagControllerForAdministration::class . '@edit');
            $this->router->post('tag/list', TagControllerForAdministration::class . '@list');
            $this->router->post('tag/patch', TagControllerForAdministration::class . '@patch');
            $this->router->post('tag/relation', TagControllerForAdministration::class . '@relation');
            $this->router->post('tag/user', TagControllerForAdministration::class . '@user');
            $this->router->post('upload', UploadControllerForAdministration::class . '@handle');
            $this->router->post('user', UserControllerForAdministration::class . '@user');
            $this->router->post('user/ban', UserControllerForAdministration::class . '@ban');
            $this->router->post('user/create', UserControllerForAdministration::class . '@create');
            $this->router->post('user/edit', UserControllerForAdministration::class . '@edit');
            $this->router->post('user/group', UserControllerForAdministration::class . '@group');
            $this->router->post('user/list', UserControllerForAdministration::class . '@list');
            $this->router->post('user/tag', UserControllerForAdministration::class . '@tag');
            $this->router->post('verification', VerificationControllerForAdministration::class . '@verify');
            $this->router->post('verification/send', VerificationControllerForAdministration::class . '@send');
        });
        $this->router->group(['middleware' => ['cross', 'web'], 'prefix' => 'api/member/user'], function () {
            $this->router->post('login', UserControllerForUser::class . '@login');
            $this->router->post('register', UserControllerForUser::class . '@register');
            $this->router->post('way', UserControllerForUser::class . '@way');
        });
    }
}
