<?php

namespace WiseShareBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Mautic\CoreBundle\Factory\MauticFactory;
use AppBundle\Entity\Visit;
use AppBundle\Entity\VisitShare;
use AppBundle\Entity\Share;
use AppBundle\Entity\Lead;
use AppBundle\Form\LeadType;

class DefaultController extends Controller
{
    const CSRF_TOKEN_ID = 'NVWiseShare';

    /**
     * @Route("/my/shares", name="my_shares")
     */
    public function mySharesAction()
    {
        return $this->render('WiseShareBundle:Default:my_shares.html.twig');
    }

    /**
     * @Route("/my/info", name="my_info")
     */
    public function myInfoAction()
    {
        return $this->render('WiseShareBundle:Default:my_info.html.twig');
    }

    /**
     * @Route("my/info/edit", name="my_info_edit")
     */
    public function editLeadAction(Request $request)
    {
        $sessionId = session_id();

        if (!$sessionId) {
            return new Response('Could not find your information at this time.');
        }

        $visit = $this->getDoctrine()->getRepository('AppBundle:Visit')->findOneBy(
            array('sessId' => $sessionId),
            array('id' => 'DESC')
        );

        $device = $visit->getDevice();

        $lead = $device->getLead();

        if (!$lead) {
            $lead = new Lead();
        }

        $form = $this->createForm(LeadType::class, $lead);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // TODO: Not sure if there is a better approach
            $data = $form->getData();
            $lead->setFirstName($data->getFirstName());
            $lead->setLastName($data->getLastName());
            $lead->setTitle($data->getTitle());
            $lead->setEmail($data->getEmail());
            $lead->setMobile($data->getMobile());
            $lead->setWechat($data->getWechat());
            $lead->setCompany($data->getCompany());
            $lead->setPosition($data->getPosition());

            $em = $this->getDoctrine()->getManager();
            $em->persist($lead);
            $em->flush();

            $device->setLead($lead);
            $em->persist($device);
            $em->flush();

            return $this->redirectToRoute('my_info');
        }

        return $this->render('WiseShareBundle:Default:my_info_edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function codeAction($currentUrl, $request)
    {
        $newUrl = $currentUrl;
        $token = $this->extractShareToken($newUrl);

        $fromShare = NULL;

        if ($token) {
            $visitShare = $this->findVisitShare($token);
            if ($visitShare) {
                $fromShare = $visitShare->getToShare();
            }
        }

        $mf = new MauticFactory($this->container);

        $visit = new Visit();
        $visit->setSessId('dummy');
        $visit->setUrl($currentUrl);
        $visit->setReferer($request->server->get('HTTP_REFERER'));
        $visit->setDateHit(new \DateTime('now'));
        $visit->setIp($mf->getIpAddressFromRequest());
        $visit->setUserAgent($request->server->get('HTTP_USER_AGENT'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($visit);
        if ($fromShare) {
            $fromShare->setReadCount($fromShare->getReadCount() + 1);
            $em->persist($fromShare);
        }
        $em->flush();

        $visitShare = $this->createVisitShare($visit, $fromShare);

        $shareUrl = $this->appendShareToken($newUrl, $visitShare->getToken());

        $csrfToken = $this->getCsrfTokenManager()->getToken(self::CSRF_TOKEN_ID);

        $js = <<<JS
(function(w, n) {
    w[n] = w[n] || {
        u: function() {
            return '{$shareUrl}';
        },
        c: function() {
            return '{$csrfToken}';
        },
        s: function() {
            var t = this, a = [this.u(), this.c()];
            for (var i = 0; i < arguments.length; i++) {
                a.push(arguments[i]);
            }
            $.post('/nws/s', {'d[]': a}, function(d) {
                t.u = function() {
                    return d.u;
                };
            });
        }
    };
})(window, 'NWiseShare');
JS;

        $js = \JSMin::minify($js);

        return $this->render(
            'WiseShareBundle:Default:code.html.twig',
            array('js' => $js)
        );
    }

    /**
     * @Route("/nws/s")
     */
    public function shareAction(Request $request)
    {
        $data = $request->request->get('d');
        $url = $data[0];
        $csrfToken = $data[1];
        $source = $data[2];
        $target = $data[3];
        $status = $data[4];
        $title = $data[5];
        $imageUrl = $data[6];

        if ($status != 'success') {
            return new Response(
                json_encode('invalid status'),
                400,
                array('Content-Type' => 'application/json')
            );
        }

        if (!$this->getCsrfTokenManager()
            ->isTokenValid(new CsrfToken(self::CSRF_TOKEN_ID, $csrfToken))
        ) {
            return new Response(
                json_encode('wrong place'),
                403,
                array('Content-Type' => 'application/json')
            );
        }

        $token = $this->extractShareToken($url);
        $visitShare = $this->findVisitShare($token);

        // proceed only if it is a token we generated
        if ($visitShare) {
            $share = new Share();
            $share->setSource($source);
            $share->setTarget($target);
            $share->setSharedDate(new \DateTime('now'));
            $share->setStatus($status);
            $share->setUrl($url);
            $share->setTitle($title);
            $share->setImageUrl($imageUrl);
            $share->setParent($visitShare->getFromShare());
            $share->setDevice($visitShare->getVisit()->getDevice());
            $share->setReadCount(0);

            $em = $this->getDoctrine()->getManager();
            $em->persist($share);
            $em->flush();

            $visitShare->setToShare($share);
            $em->persist($visitShare);
            $em->flush();

            // generate a new share token
            $newVisitShare = $this->createVisitShare($visitShare->getVisit(), $visitShare->getFromShare());

            $data = array(
                'u' => $this->appendShareToken($url, $newVisitShare->getToken()),
            );

            return new Response(
                json_encode($data),
                200,
                array('Content-Type' => 'application/json')
            );
        } else {
            return new Response(
                json_encode('visit not found'),
                404,
                array('Content-Type' => 'application/json')
            );
        }
    }

    /**
     * @Route("/api/my/info")
     */
    public function myInfo()
    {
        if ($device = $this->getDeviceOfCurrnetSession()) {
            if ($lead = $device->getLead()) {
                $data = array(
                    'firstName' => $lead->getFirstName(),
                    'lastName' => $lead->getLastName(),
                    'email' => $lead->getEmail(),
                    'mobile' => $lead->getMobile(),
                    'company' => $lead->getCompany(),
                    'position' => $lead->getPosition(),
                );

                return new Response(
                    json_encode($data),
                    200,
                    array('Content-Type' => 'application/json')
                );
            }
        }

        return new Response(
            json_encode('Could not find your information at this time.'),
            404,
            array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/api/my/shares")
     */
    public function myShares()
    {
        $sessionId = session_id();

        if (!$sessionId) {
            return new Response(
                json_encode('Could not find your information at this time.'),
                404,
                array('Content-Type' => 'application/json')
            );
        }

        $visit = $this->getDoctrine()->getRepository('AppBundle:Visit')->findOneBy(
            array('sessId' => $sessionId),
            array('id' => 'DESC')
        );

        $device = $visit->getDevice();

        $shareRepo = $this->getDoctrine()->getRepository('AppBundle:Share');

        $shares = $shareRepo->findBy(
            array('device' => $device->getId()),
            array('id' => 'DESC')
        );

        $data = array();

        foreach ($shares as $share) {
            $data[] = array(
                'title' => $share->getTitle(),
                'url' => $share->getUrl(),
                'imageUrl' => $share->getImageUrl(),
                'readCount' => $share->getReadCount(),
                'sharedCount' => $shareRepo->getSharedCount($share->getId()),
            );
        }

        return new Response(
            json_encode($data),
            200,
            array('Content-Type' => 'application/json')
        );
    }

    protected function findVisitShare($token)
    {
        $repo = $this->getDoctrine()->getRepository('AppBundle:VisitShare');
        return $repo->findOneByToken($token);
    }

    protected function createVisitShare($visit, $fromShare)
    {
        $em = $this->getDoctrine()->getManager();

        $visitShare = new VisitShare();
        $visitShare->setVisit($visit);
        $visitShare->setFromShare($fromShare);

        $em->persist($visitShare);
        $em->flush();

        $visitShare->setToken($this->generateShareToken($visitShare));

        $em->persist($visitShare);
        $em->flush();

        return $visitShare;
    }

    protected function appendShareToken($url, $token)
    {
        $sep = preg_match('/(\?|&)/', $url) ? '&' : '?';
        return $url . $sep . 'nws=' . $token;
    }

    protected function generateShareToken($syncObj)
    {
        return md5($syncObj->getId() . 'Be there or be square');
    }

    public function extractShareToken(&$url)
    {
        $param = 'nws';
        $token = '';

        $pieces = preg_split('/(\?|&)/', $url);

        foreach ($pieces as $key => $piece) {
            if (strpos($piece, $param . '=') === 0) {
                $token = explode('=', $piece)[1];
                unset($pieces[$key]);
            }
        }

        if ($token) {
            $url = implode('?', array_slice($pieces, 0, 2));
            $url = implode('&', array_merge(array($url), array_slice($pieces, 2)));
        }

        return $token;
    }

    protected function getCsrfTokenManager()
    {
        return $this->get('security.csrf.token_manager');
    }

    protected function getDeviceOfCurrnetSession()
    {
        $sessionId = session_id();

        if (!$sessionId) {
            return NULL;
        }

        $visit = $this->getDoctrine()->getRepository('AppBundle:Visit')->findOneBy(
            array('sessId' => $sessionId),
            array('id' => 'DESC')
        );

        return $visit->getDevice();
    }
}
