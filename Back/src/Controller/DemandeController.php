<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use DateTimeInterface;
use App\Entity\Demande;
use App\Entity\Projet;
use App\Repository\DemandeRepository;
use App\Repository\ProjetRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Swift_Attachment;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Workflow\WorkflowInterface;

class DemandeController extends AbstractController
{

    /**
     * @Route("/api/adddemande" )
     */

    public function adddemande(Request $request)
    {
        $serializer = $this->get('serializer');
        $data = json_decode($request->getContent(), true);
        
        $projet= $this->getDoctrine()->getRepository(Projet::class)->find($data['projet']);
      //  dd($projet);
        $user = $this->getDoctrine()->getRepository(User::class)->find($data['user']);
       // $email=$user->getEmail();
        //$nom=$user->getNom();
        $manager=$projet->getManager()->getEmail();
        if(is_null($projet->getManagerProx())==false)
        {$managerProx=$projet->getManagerProx()->getEmail();}
        
        //dd($managerProx);

        $demande = new Demande();

        $demande->setUser($user);
         $demande->setDateDebut($data['DateDebut']);
         $demande->setDateFin($data['DateFin']);
        $datedujour = date("Y-m-d H:i");
        $updated= date("Y-m-d H:i");
        $demande->setCreatedAt($datedujour);
        $demande->setUpdatedAt($updated);
       // $demande->setDateDebut(new DateTime());
      //  $demande->setDateFin(new DateTime());
        $demande->setRaison($data['raison']);
        $demande->setAdresse($data['adresse']);
        $data[0]['id'] = $demande->getId();
        $demande->setProjet($projet);
       // dd($demande);
        $em = $this->getDoctrine()->getManager();
        $em->persist($demande);
        $em->flush();
//send email
        $transport = (new Swift_SmtpTransport('smtp.mailtrap.io', 25))
        ->setUsername('a500e2fd24237f')
        ->setPassword('95b4b26917fe57');
        $img= base64_encode(file_get_contents('https://static2.clutch.co/s3fs-public/logos/talan_logo.png'));
        $mailer = new Swift_Mailer($transport);
        if(is_null($projet->getManagerProx())==false){
        $message=(new Swift_Message('Nouvelle Demande'))
        ->setFrom('talanRemote@gmail.com')
        ->setTo([$manager, $managerProx ])
        ->setBody('Bonjour, </br> </br> Vous avez une demande de télétravail en attente de validation. </br> Veuillez vérifier Talan Remote </br> </br> </br>',
          'text/html');}else{
            $message=(new Swift_Message('Nouvelle Demande'))
            ->setFrom('talanRemote@gmail.com')
            ->setTo($manager)
            ->setBody('Bonjour, </br> </br> Vous avez une demande de télétravail en attente de validation. </br> Veuillez vérifier Talan Remote </br> </br> </br>',
              'text/html');
          }
            //  $message->attach(Swift_Attachment::fromPath('https://static2.clutch.co/s3fs-public/logos/talan_logo.png'));
    //  $message ->embed(Swift_Image::fromPath('https://static2.clutch.co/s3fs-public/logos/talan_logo.png'));
       $message ->addPart(' talentueusement, </br> </br>  <img src="data:image/png;base64, '.$img.'" style=" width:100px">  </br> ', 'text/html');
  
        $mailer->send($message);

        return new JsonResponse($demande->getId());
    }
/**
 * @Route("/api/projet/{id}")
 */
public function getProjet($id){
    $projet= $this->getDoctrine()->getRepository(Projet::class)->find($id);
  //  dd($projet);
        $data[0]['id'] = $projet->getId();
        $data[0]['nom'] = $projet->getNom();
        $data[0]['manager'] = $projet->getManager()->getId();
        $data[0]['managerProx'] = $projet->getManagerProx()->getId();
    return new JsonResponse($data);
}

/**
 * @Route("/api/projets")
 */
public function Projets(){
    $projet= $this->getDoctrine()->getRepository(Projet::class)->findAll();
    //dd($projet);
    foreach ($projet  as $key=>$projet ) {
        $data[$key]['id'] = $projet->getId();
        $data[$key]['nom'] = $projet->getNom();
        $data[$key]['manager'] = $projet->getManager()->getId();
        $data[$key]['managerProx'] = $projet->getManagerProx()->getId();}
    
    return new JsonResponse($data);
}


/**
 * @Route("api/filtredDemandes/{id}")
 */
public function Manager(DemandeRepository $repo, Request $request, $id){ 
    $user = $this->getDoctrine()->getRepository(User::class)->find($id);
    $getRole=$user->getRoles();
   $role=$getRole[0];
   // dd($role);     
     $filtredDemandes= $repo->findRequestsForManager($role, $user);
   //  dd($filtredDemandes);
  //$fdemandes=$filtredDemandes[0];
   //  $data[0]['id'] = $fdemandes->getId();
    //dd($fdemandes);
     foreach ($filtredDemandes as $key =>$demande) {
         $data[$key]['id'] = $demande->getId();
         $data[$key]['user'] = $demande->getUser()->getNom();
        // $data[$key]['user'] = $demande->getUser()->getPrenom();
         $data[$key]['raison'] = $demande->getRaison();
         $data[$key]['dateDebut'] = $demande->getDateDebut();
        $data[$key]['dateFin'] = $demande->getDateFin();
         $data[$key]['adresse'] = $demande->getAdresse();
         $data[$key]['status'] = $demande->getStatus();
     }
     
     return new JsonResponse($data);
 }

/**
 * @Route("api/filtredDemandesProx/{id}")
 */
public function ManagerProx(DemandeRepository $repo, Request $request, $id){ 
    $user = $this->getDoctrine()->getRepository(User::class)->find($id);
    $getRole=$user->getRoles();
   $role=$getRole[0];
   // dd($role);     
     $filtredDemandes= $repo->findRequestsForManagerProx($role, $user);
   //  dd($filtredDemandes);
  //$fdemandes=$filtredDemandes[0];
   //  $data[0]['id'] = $fdemandes->getId();
    //dd($fdemandes);
     foreach ($filtredDemandes as $key =>$demande) {
         $data[$key]['id'] = $demande->getId();
         $data[$key]['user'] = $demande->getUser()->getNom();
        // $data[$key]['user'] = $demande->getUser()->getPrenom();
         $data[$key]['raison'] = $demande->getRaison();
         $data[$key]['dateDebut'] = $demande->getDateDebut();
        $data[$key]['dateFin'] = $demande->getDateFin();
         $data[$key]['adresse'] = $demande->getAdresse();
         $data[$key]['status'] = $demande->getStatus();
     }
     
     return new JsonResponse($data);
 }


/**
* @Route("api/getProjectsByUser/{id}", name="getProjectsByUser")
*/
public function getProjectsByUser( $id, ProjetRepository $projetRespository)
{$user=$this->getDoctrine()->getRepository(User::class)->find($id);
   $projets=$projetRespository->findProjects($user);
   foreach ($projets as $key => $projet) {
   $data[$key]['id'] = $projet->getId();
   $data[$key]['nom'] = $projet->getNom();
   $data[$key]['surSite'] = $projet->getSurSite();
   $data[$key]['manager'] = $projet->getManager()->getId();
if(is_null($data[$key]['managerProx']= $projet->getManagerProx())==false)
   {
   // dd(is_null($data[$key]['managerProx']= $projet->getManagerProx()));
       $data[$key]['managerProx'] = $projet->getManagerProx()->getId();}
       
}
//dd($data);
return new JsonResponse($data);

}
   /**
     * @Route("/api/affichedemande/{id}" , name="affichedemande")
     */
    public function affichedemande($id)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        $demande = $this->getDoctrine()
            ->getRepository(Demande::class)
            ->findBy(array('user' => $user));
        foreach ($demande  as $key => $user) {
            $data[$key]['id'] = $user->getId();
            $data[$key]['iduser'] = $user->getUser()->getId();
            $data[$key]['raison'] = $user->getRaison();
            $data[$key]['dateDebut'] = $user->getDateDebut();
            $data[$key]['dateFin'] = $user->getDateFin();
            $data[$key]['adresse'] = $user->getAdresse();
            $data[$key]['status'] = $user->getStatus();
            
        }
        return new JsonResponse($data);
    }
}
