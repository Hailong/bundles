<?php

namespace Nvidia\QuickQRCodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $url = $request->headers->get('referer');

        $codeContents = $url;

        // we need to generate filename somehow,  
        // with md5 or with database ID used to obtains $codeContents... 
        $fileName = '005_file_'.md5($url).'.png';

        $pngAbsoluteFilePath = dirname($this->container->getParameter('kernel.root_dir')).'/web/bundles/nvidiaquickqrcode/'.$fileName;
        $urlRelativeFilePath = $request->getSchemeAndHttpHost().'/bundles/nvidiaquickqrcode/'.$fileName;

        // generating 
        if (!file_exists($pngAbsoluteFilePath)) {
            include dirname($this->container->getParameter('kernel.root_dir')).'/src/Nvidia/QuickQRCodeBundle/vendor/phpqrcode/qrlib.php';
            \QRcode::png($codeContents, $pngAbsoluteFilePath);
            // echo 'File generated!'; 
            // echo '<hr />'; 
        } else {
            // echo 'File already generated! We can use this cached file to speed up site on common codes!'; 
            // echo '<hr />'; 
        }

        // echo 'Server PNG File: '.$pngAbsoluteFilePath; 
        // echo '<hr />'; 

        return $this->render(
            'NvidiaQuickQRCodeBundle:Default:quick_qr_code.js.twig',
            ['img_url' => $urlRelativeFilePath],
            new Response('', 200, ['Content-Type' => 'text/javascript'])
        );
    }
}
