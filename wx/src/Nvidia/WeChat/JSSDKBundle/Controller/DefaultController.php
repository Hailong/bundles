<?php

namespace Nvidia\WeChat\JSSDKBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EasyWeChat\Foundation\Application;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $url = $request->headers->get('referer');

        $whitelist = [
            'xxx.domain1.com',
            'xxx.domain2.com',
            'localhost',
        ];

        if (!in_array(
            parse_url($url, PHP_URL_HOST),
            $whitelist
        )) {
            throw $this->createNotFoundException('The file does not exist');
        }

        $options = [
            'debug' => true,
            'app_id' => 'wxxxxxxxxxxxxxxxxxx',
            'secret' => 'aexxxxxxxxxxxxxxxxxxxxxx',

            'log' => [
                'level' => 'debug',
                'file' => '/tmp/easywechat.log',
            ],
        ];

        $app = new Application($options);
        $js = $app->js;
        $js->setUrl($url);
        $config = $js->config(
            [
                'onMenuShareTimeline',
                'onMenuShareAppMessage',
                'onMenuShareQQ',
                'onMenuShareWeibo',
                'onMenuShareQZone',
            ],
            $debug = false,
            $beta = false,
            $json = true
        );

        return $this->render(
            'NvidiaWeChatJSSDKBundle:Default:share.js.twig',
            ['config' => $config],
            new Response('', 200, ['Content-Type' => 'text/javascript'])
        );
    }
}
