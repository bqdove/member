<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-07-01 15:50
 */
namespace Notadd\Member;

use Notadd\Foundation\Module\Abstracts\Definition as AbstractDefinition;

/**
 * Class Definition.
 */
class Definition extends AbstractDefinition
{
    /**
     * Description of module.
     *
     * @return string
     */
    public function description()
    {
        return 'Notadd 用户管理模块';
    }

    /**
     * Entries for module.
     *
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function entries()
    {
        return [
            'administration' => [
                'notadd/content'   => [
                    'permissions' => '',
                    'scripts'     => asset('assets/member/administration/js/module.min.js'),
                    'stylesheets' => asset('assets/member/administration/css/module.min.css'),
                ],
            ],
        ];
    }

    /**
     * Name of module.
     *
     * @return string
     */
    public function name()
    {
        return '用户中心';
    }

    /**
     * Requires of module.
     *
     * @return array
     */
    public function requires()
    {
        return [];
    }

    /**
     * Version of module.
     *
     * @return string
     */
    public function version()
    {
        return '1.0.0';
    }
}
