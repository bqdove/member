<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-06 21:07
 */
namespace Notadd\Member\Controllers;

use Notadd\Foundation\Routing\Abstracts\Controller;
use Notadd\Member\Handlers\Socialite\AuthHandler;
use Notadd\Member\Handlers\Socialite\TokenHandler;

/**
 * Class SocialiteController.
 */
class SocialiteController extends Controller
{
    /**
     * @param \Notadd\Member\Handlers\Socialite\AuthHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Symfony\Component\HttpFoundation\RedirectResponse|\Zend\Diactoros\Response
     */
    public function auth(AuthHandler $handler)
    {
        if ($this->request->expectsJson()) {
            return $handler->toResponse()->generateHttpResponse();
        } else {
            $socialite = $handler->authentic();

            return $socialite->redirect();
        }
    }

    /**
     * @param \Notadd\Member\Handlers\Socialite\TokenHandler $handler
     *
     * @return bool|\Illuminate\Support\Collection|\Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|string|\Zend\Diactoros\Response
     */
    public function token(TokenHandler $handler)
    {
        if ($this->request->expectsJson()) {
            return $handler->toResponse()->generateHttpResponse();
        } else {
            $info = $handler->tokenize();
            if ($info === false) {
                return '授权失败！';
            } else {
                return $info;
            }
        }
    }
}
