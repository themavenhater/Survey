<?php

namespace FOSuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $id = $request->getSession()->getId();
        $LastSurvey = 50;
        $ipAddress = $request->getClientIp();
        $request->cookies->get('PHPSESSID');

        $response = new Response();


        dump($response);
        die();
        //$request->cookies->get('myCookie');

        /*$response = new Response();
        $response->headers->getCookies();*/


        return $this->render('FOSuBundle:Default:index.html.twig');

    }
}
