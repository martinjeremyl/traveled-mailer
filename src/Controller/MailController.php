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
        $response = new JsonResponse();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
        $response->setData(array("Bienvenue sur le service mailing Traveled"));
        return $response;
    }

    public function sendWelcomeMail($email, $password){
        $response = new Response();
        $message = (new \Swift_Message("Bienvenu sur traveled !"))
                ->setFrom(array("travelednoreply@gmail.com"=>"travelednoreply@gmail.com"))
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    'mail/loginMail.html.twig',
                    array('login' => $email)
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
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    'mail/passwordMail.html.twig',
                    array('password' => $password)
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
        return $this->render('mail/loginMail.html.twig');
    }
}