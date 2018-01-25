<?php

namespace  App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;

class MailController extends Controller
{


    public function index(){
        return new Response("Bienvenu sur l'api mailing traveled ! ");
    }

    public function sendWelcomeMail(Request $request,LoggerInterface $logger){
        $logger->info($request->get('to'));
        $response = new JsonResponse();
        $message = (new \Swift_Message("Bienvenu sur traveked"))
                ->setFrom(array("travelednoreply@gmail.com"=>"travelednoreply@gmail.com"))
            ->setTo($request->get('to'))
            ->setBody(
                $this->renderView(
                    'mail/welcome.html.twig',
                    array('link' => $request->get('link'))
                ),
                'text/html'
            );
        try {
            $this->get('mailer')->send($message);
        } catch (Exception $e){
            $response->setStatusCode(500,"Impossible d'envoyer le mail");
            return $response;
        }
        $response->setStatusCode(200,"Email sent successfully");
        return $response;
    }
}