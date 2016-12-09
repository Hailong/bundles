<?php

namespace Nvidia\WeChat\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nvidia\WeChat\BackendBundle\Entity\WeChatEvent;
use Nvidia\WeChat\BackendBundle\Form\WelcomeType;
use Nvidia\WeChat\BackendBundle\Form\ApiExplorerType;
use EasyWeChat\Core\Exceptions\HttpException;

class EnterpriseSolutionsController extends CommonController
{
    public function serverAction()
    {
        $server = $this->get('nvidia_we_chat_backend.enterprise_solutions_server');
        return $server->run();
    }

    public function menusAction()
    {
        $server = $this->get('nvidia_we_chat_backend.enterprise_solutions_server');
        $menu = $server->getMenuHandle();
        $menus = $menu->current();
        // var_dump($menus);

        // $response = new JsonResponse($menus);
        // $response->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
        // return $response;

        $json = json_encode($menus, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
        return new Response(<<<EOD
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <h3>JSON Output:</h3>
    <code>$json</code>
</body>
</html>
EOD
        );
    }

    public function apiExplorerAction(Request $request)
    {
        $form = $this->createForm(ApiExplorerType::class);

        $form->handleRequest($request);

        $response = '';

        if ($form->isSubmitted() && $form->isValid()) {
            $lastTime = apcu_fetch('wechat_api_explorer_last_request');
            if ($lastTime && time() - $lastTime < 3) {
                $response = 'Too often request. Wait at least 3 seconds to make another API call.';
            } else {
                apcu_store('wechat_api_explorer_last_request', time());

                $data = $form->getData();

                $api = ApiExplorerType::WECHAT_APIS[$data['api']];
                $from = $data['beginDate']->format('Y-m-d');
                $to = $data['endDate']->format('Y-m-d');

                $server = $this->get('nvidia_we_chat_backend.enterprise_solutions_server');
                $stats = $server->getStatsHandle();

                try {
                    $response = $stats->parseJSON('json', [
                        'https://api.weixin.qq.com/datacube/' . $api,
                        [
                            'begin_date' => $from,
                            'end_date' => $to,
                        ]
                    ]);
                } catch (HttpException $e) {
                    $response = $e->getMessage();
                }

                $response = json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
            }
        }

        return $this->render('NvidiaWeChatBackendBundle:EnterpriseSolutions:api_explorer.html.twig', [
            'form' => $form->createView(),
            'response' => $response,
        ]);
    }

    public function welcomeAction(Request $request)
    {
        $event = $this->fetchEvent($request);

        if ($event->getRegisterTime()) {
            return $this->redirectToRoute('nvidia_wechat_form_enterprise_solutions_welcome_success', [
                'evt' => $event->getEventCode(),
            ]);
        }

        $form = $this->createForm(WelcomeType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();
            $event->setRegisterTime(time());

            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('nvidia_wechat_form_enterprise_solutions_welcome_success', [
                'evt' => $event->getEventCode(),
            ]);
        }

        $openId = $event->getFromUserName();
        $server = $this->get('nvidia_we_chat_backend.enterprise_solutions_server');

        return $this->render(
            'NvidiaWeChatBackendBundle:EnterpriseSolutions:welcome.html.twig',
            [
                'time'     => $this->getTimeString(time()),
                'openid'   => $openId,
                'unionid'  => $server->getUserUnionId($openId),
                'nickname' => $server->getUserNickname($openId),
                'avatar'   => $server->getAvatarUrl($openId),
                'form'     => $form->createView(),
            ]
        );
    }

    public function successAction(Request $request)
    {
        $event = $this->fetchEvent($request);
        return $this->render('NvidiaWeChatBackendBundle:EnterpriseSolutions:success.html.twig', [
            'time' => $this->getTimeString($event->getRegisterTime()),
        ]);
    }

    private function fetchEvent(Request $request)
    {
        $eventCode = $request->query->get('evt');

        $event = null;

        if ($eventCode) {
            $event = $this->getDoctrine()
                ->getRepository('NvidiaWeChatBackendBundle:WeChatEvent')
                ->findOneByEventCode($eventCode);
        }

        if (!$event) {
            throw $this->createNotFoundException('Invalid URL!');
        }

        return $event;
    }

    private function getTimeString($timestamp) {
        return date("g:i A", $timestamp);
    }
}
