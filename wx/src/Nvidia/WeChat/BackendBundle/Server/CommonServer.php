<?php

namespace Nvidia\WeChat\BackendBundle\Server;

use EasyWeChat\Foundation\Application;

abstract class CommonServer
{
    private $app;
    private $cache;
    private $users = [];

    abstract public function handleMessage($message);

    public function __construct($cache, $appId, $secret, $token, $debug = false)
    {
        $this->cache = $cache;

        $options = [
            'debug'  => $debug,
            'app_id' => $appId,
            'secret' => $secret,
            'token'  => $token,
            'cache'  => $cache,

            'log' => [
                'level' => 'debug',
                'file' => '/tmp/easywechat.log',
            ],
        ];

        $this->app = new Application($options);

        $this->app->server->setMessageHandler([$this, 'handleMessage']);
    }

    public function run()
    {
        $response = $this->app->server->serve();
        // $response->send(); // Laravel 里请使用：return $response;

        return $response;
    }

    public function getMenuHandle()
    {
        return $this->app->menu;
    }

    public function getStatsHandle()
    {
        return $this->app->stats;
    }

    public function getUserUnionId($openId)
    {
        return $this->getUser($openId)->unionid;
    }

    public function getUserNickname($openId)
    {
        return $this->getUser($openId)->nickname;
    }

    public function getAvatarUrl($openId)
    {
        return $this->getUser($openId)->headimgurl;
    }

    protected function getCache()
    {
        return $this->cache;
    }

    protected function getUser($openId)
    {
        if (!isset($this->users[$openId])) {
            $userService = $this->app->user;
            $user = $userService->get($openId);
            $this->users[$openId] = $user;
        }

        return $this->users[$openId];
    }
}
