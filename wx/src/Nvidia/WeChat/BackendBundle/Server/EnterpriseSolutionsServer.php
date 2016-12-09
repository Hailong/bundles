<?php

namespace Nvidia\WeChat\BackendBundle\Server;

use Nvidia\WeChat\BackendBundle\Entity\WeChatEvent;
use EasyWeChat\Message\Text;

class EnterpriseSolutionsServer extends CommonServer
{
    const WELCOME_MESSAGE = <<<EOT
欢迎关注英伟达企业级公众号！在这里，您将获得人工智能计算最前沿的科技信息，以及全球人工智能、自动驾驶、高性能计算、视觉计算等行业的最新趋势与应用。\n\n同时欢迎加入英伟达企业级N粉俱乐部——英伟达AI创想会。现在加入，即可获得开门红包一个。还可免费享受会员专属特权，您将获得人工智能计算相关行业最新趋势报告、最新产品技术白皮书、免费参与线下培训、最新产品试用和定期抽奖活动等会员特权和福利，并结识一群走在AI 前沿的志同道合的小伙伴们。<a href="http://wx.marketingneat.com/form/es/welcome?evt=%s">点击注册</a>，让我们一同为未来创想！\n\n第一时间收到前沿信息推送，只需将微信更新至最新版本，进入英伟达订阅号，点击右上角小人进入选项设置至顶公众号即可！
EOT;

    public function __construct($em, $cache, $appId, $secret, $token, $debug = false) {
        parent::__construct($cache, $appId, $secret, $token, $debug);

        $this->em = $em;
    }

    public function handleMessage($message)
    {
        switch ($message->MsgType) {
            case 'event':
                # 事件消息...
                $eventCode = $this->getEventCode($message);

                switch ($message->Event) {
                    case 'subscribe':
                        return new Text([
                            'content' => sprintf(self::WELCOME_MESSAGE, $eventCode),
                        ]);
                        break;

                    case 'CLICK':
                        # code...
                        break;

                    default:
                        # code...
                        break;
                }
                break;
            case 'text':
                # 文字消息...
                break;
            case 'image':
                # 图片消息...
                break;
            case 'voice':
                # 语音消息...
                break;
            case 'video':
                # 视频消息...
                break;
            case 'location':
                # 坐标消息...
                break;
            case 'link':
                # 链接消息...
                break;
            // ... 其它消息
            default:
                # code...
                break;
        }
        // ...
    }

    protected function getEventCode($message)
    {
        $key = $message->FromUserName . $message->CreateTime;
        $eventCode = $this->getCache()->fetch($key);

        if (!$eventCode) {
            $eventCode = md5($key);

            $event = new WeChatEvent();
            $event->setEvent($message->Event);
            $event->setEventCode($eventCode);
            $event->setToUserName($message->ToUserName);
            $event->setFromUserName($message->FromUserName);
            $event->setCreateTime($message->CreateTime);

            $this->em->persist($event);
            $this->em->flush();

            $this->getCache()->save($key, $eventCode);
        }

        return $eventCode;
    }
}
