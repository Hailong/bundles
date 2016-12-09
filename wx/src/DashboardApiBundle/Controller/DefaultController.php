<?php

namespace DashboardApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/api/dashboard/visits")
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Visit');

        $visits = $repository->findBy(
            array(),
            array('id' => 'DESC'),
            10
        );

        $data = array();

        foreach ($visits as $visit) {
            $device = $visit->getDevice();

            $data[] = array(
                'type' => 'visits',
                'id'   => $visit->getId(),
                'attributes' => array(
                    'hit'  => $visit->getDateHit() ? $visit->getDateHit()->format('Y-m-d H:i:s') : '',
                    'left' => $visit->getDateLeft() ? $visit->getDateLeft()->format('Y-m-d H:i:s') : '',
                    'url'  => $visit->getUrl(),
                    'platform' => $device ? $device->getPlatform() : '',
                    'fp' => $device ? $device->getFingerprint() : '',
                ),
            );
        }

        return new JsonResponse(array('data' => $data));
    }

    /**
     * @Route("/api/dashboard/shares")
     */
    public function sharesAction()
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:VisitShare');

        $visitsShares = $repository->findShares();

        $data = array();

        foreach ($visitsShares as $vs) {
            $share = $vs->getToShare();

            $reads = $repository->findReads($share->getId());
            $readsData = array();

            foreach ($reads as $read) {
                $device = $read->getVisit()->getDevice();

                $readsData[] = array(
                    'url' => $read->getVisit()->getUrl(),
                    'time' => $read->getVisit()->getDateHit()->format('Y-m-d H:i:s'),
                    'platform' => $device ? $device->getPlatform() : '',
                    'fp' => $device ? $device->getFingerprint() : '',
                );
            }

            $device = $vs->getVisit()->getDevice();

            $data[] = array(
                'type' => 'shares',
                'id' => $vs->getId(),
                'attributes' => array(
                    'time' => $share->getSharedDate()->format('Y-m-d H:i:s'),
                    'source' => $share->getSource(),
                    'target' => $share->getTarget(),
                    'platform' => $device ? $device->getPlatform() : '',
                    'fp' => $device ? $device->getFingerprint() : '',
                    'reads' => $readsData,
                ),
            );
        }

        return new JsonResponse(array('data' => $data));
    }
}
