<?php

namespace MauticStubBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Mautic\PageBundle\Controller\PublicController;
use Mautic\CoreBundle\Helper\TrackingPixelHelper;
use WiseShareBundle\Controller\DefaultController;
use AppBundle\Entity\Device;

class PagePublicController extends PublicController
{
    public function trackingImageAction()
    {
        // //Create page entry
        // /** @var \Mautic\PageBundle\Model\PageModel $model */
        // $model   = $this->factory->getModel('page');
        // $model->hitPage(null, $this->request);

        // return TrackingPixelHelper::getResponse($this->request);

        $request = $this->container->get('request_stack')->getCurrentRequest();

        $shareUrl = $request->query->get('nws');
        $fingerprint = $request->query->get('fingerprint');
        $platform = $request->query->get('platform');
        $sessionId = session_id();

        $wsc = new DefaultController();
        $shareToken = $wsc->extractShareToken($shareUrl);

        $vsRepo = $this->getDoctrine()->getRepository('AppBundle:VisitShare');
        $visitShare = $vsRepo->findOneByToken($shareToken);

        if ($visitShare && $visit = $visitShare->getVisit()) {
            // complete the last visit
            $vRepo = $this->getDoctrine()->getRepository('AppBundle:Visit');
            $last = $vRepo->findOneBy(
                array('sessId' => $sessionId),
                array('id' => 'DESC')
            );
            if ($last) {
                $last->setDateLeft(new \DateTime('now'));
            }

            $deviceRepo = $this->getDoctrine()->getRepository('AppBundle:Device');
            $device = $deviceRepo->findOneByFingerprint($fingerprint);

            if (!$device) {
                $device = new Device();
            }

            $device->setFingerprint($fingerprint);
            $device->setPlatform($platform);

            $em = $this->getDoctrine()->getManager();
            $em->persist($device);
            $em->flush();

            $visit->setSessId($sessionId);
            $visit->setDevice($device);
            $em->persist($visitShare);
            $em->flush();
        }

        return TrackingPixelHelper::getResponse($request);
    }
}
