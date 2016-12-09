<?php

namespace MauticStubBundle\Controller;

use Mautic\CoreBundle\Controller\JsController;
use Mautic\CoreBundle\Event\BuildJsEvent;
use Mautic\CoreBundle\EventListener\BuildJsSubscriber as CoreBuildJsSubscriber;
use Mautic\PageBundle\EventListener\BuildJsSubscriber as PageBuildJsSubscriber;
use Symfony\Component\HttpFoundation\Response;
use MauticStubBundle\Factory\DummyFactory;

/**
 * Class JsController
 */
class CoreJsController extends JsController
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        $debug = false;
        $event = new BuildJsEvent($this->getJsHeader(), $debug);

        $factory = new DummyFactory($this->container);
        $coreSubscriber = new CoreBuildJsSubscriber($factory);
        $pageSubscriber = new PageBuildJsSubscriber($factory);
        $coreSubscriber->onBuildJs($event);
        $pageSubscriber->onBuildJs($event);

        return new Response($event->getJs(), 200, array('Content-Type' => 'application/javascript'));
    }
}
