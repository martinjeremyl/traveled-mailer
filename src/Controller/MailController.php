<?php

namespace  App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class MailController extends Controller
{


    public function indexAction(){
        return new Response("Bienvenu sur l'api mailing traveled ! ");
    }

    public function sendWelcomeMail(Request $request){

        $message = (new \Swift_Message("Bienvenu sur traveked"))
                ->setFrom(array("Traveled"=>"travelednoreply@gmail.com"))
            ->setTo($request->get('to'))
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/registration.html.twig',
                    array('link' => $request->get('link'))
                ),
                'text/html'
            );

        $this->get('mailer')->send($message);
    }
}