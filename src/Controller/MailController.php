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
        return new Response("Bienvenue sur l'api mailing traveled ! ");
    }

    public function sendWelcomeMail(Request $request){
        $response = new JsonResponse();
        $message = (new \Swift_Message("Bienvenu sur traveled !"))
                ->setFrom(array("travelednoreply@gmail.com"=>"travelednoreply@gmail.com"))
            ->setTo($request->get('to'))
            ->setBody(
                $this->renderView(
                    'mail/loginMail.html.twig',
                    array('login' => $request->get('to'))
                ),
                'text/html'
            );
        try {
            $this->get('mailer')->send($message);
        } catch (Exception $e){
            $response->setStatusCode(500,"Impossible d'envoyer le mail login");
            return $response;
        }
        $message = (new \Swift_Message("Voici votre mot de passe"))
            ->setFrom(array("travelednoreply@gmail.com"=>"travelednoreply@gmail.com"))
            ->setTo($request->get('password'))
            ->setBody(
                $this->renderView(
                    'mail/passwordMail.html.twig',
                    array('login' => $request->get('to'))
                ),
                'text/html'
            );
        try {
            $this->get('mailer')->send($message);
        } catch (Exception $e){
            $response->setStatusCode(500,"Impossible d'envoyer le mot de passe.");
            return $response;
        }

        $response->setStatusCode(200,"Email sent successfully");
        return $response;
    }

    public function checkEmailFront () {
        return $this->renderView('mail/loginMail.html.twig');
    }
}