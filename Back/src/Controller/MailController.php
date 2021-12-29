<?php

namespace App\Controller;

use App\Form\ContactType;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    /**
     * @Route("/mail", name="mail")
     */
    public function index(Request $request,\Swift_Mailer $mailer)
    {$form=$this->createForm(ContactType::class);
        $form->handleRequest($request);
     //   if($form->isSubmitted() && $form->isValid()){
           // $contact= $form->getData();
            $transport = (new Swift_SmtpTransport('smtp.mailtrap.io', 25))
            ->setUsername('a500e2fd24237f')
            ->setPassword('95b4b26917fe57');
            $mailer = new Swift_Mailer($transport);
            $message=(new Swift_Message('Nouvelle Demande'))
            ->setFrom(['user@talan.com'=>'user'])
            ->setTo(['manager@talan.com'=>'manager'])
            ->setBody('Vous avez une demande en attente');
            
            $mailer->send($message);
           // dd($message);
   //     }
        return  new JsonResponse('mail envoyé');
    }
}
