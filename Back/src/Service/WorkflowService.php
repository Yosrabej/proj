<?php
namespace App\Service;

use App\Entity\Demande;

use App\Repository\DemandeRepository;
use App\Repository\ProjetRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Workflow\WorkflowInterface;

class WorkflowService
{
protected $entityManager;
protected $userRepository;
protected $demandeRespository;
public $projetRepository;
public $remoteWorkflow;
public function __construct(WorkflowInterface $remoteWorkflow, EntityManagerInterface $entityManager, ProjetRepository $projetRepository, UserRepository $userRepository, DemandeRepository $demandeRespository)
{
$this->remoteWorkflow = $remoteWorkflow;
$this->entityManager = $entityManager;
$this->userRepository = $userRepository;
$this->demandeRespository = $demandeRespository;
$this->projetRepository=$projetRepository;
} 
public function request($id, $userId, $projId){
    $demande = $this->demandeRespository->find($id);
    $user = $this->userRepository->find($userId);     
        $projets=$this->projetRepository->find($projId);
        //dd($projets->getManagerProx());
        if(is_null($projets->getManagerProx())==false)
        { //dd('to_pending');
            $data[0]['managerProx']=$projets->getManagerProx()->getId();
            $this->remoteWorkflow->apply($demande, 'to_pending');
        }
            else{
                //dd('to_pendingone');
                $this->remoteWorkflow->apply($demande, 'to_pending_oneManager');
            }
        $this->entityManager->persist($demande);
        $this->entityManager->flush();
        
        return new JsonResponse("demande envoyée");
}

public function refuseA($id, $userId){
    $demande = $this->demandeRespository->find($id);
        //dd($request);
        $user = $this->userRepository->find($userId);
        $typecontrat = $user->getTypeContrat();
       // $projet= $this->getDoctrine()->getRepository(Projet::class)->find($projId);
       // $surSite= $projet->getSurSite();
        $this->remoteWorkflow->apply($demande, 'to_automatically_refuse');
      //  $this->entityManager->persist($demande);
        $this->entityManager->flush();

//send email from admin to user
$demande = $this->demandeRespository->find($id);
$date=$demande->getCreatedAt();
$emailUser=$demande->getUser()->getEmail();
$nomUser=$demande->getUser()->getNom();
$transport = (new Swift_SmtpTransport('smtp.mailtrap.io', 25))
->setUsername('a500e2fd24237f')
->setPassword('95b4b26917fe57');
$img= base64_encode(file_get_contents('https://static2.clutch.co/s3fs-public/logos/talan_logo.png'));
$mailer = new Swift_Mailer($transport);
$message=(new Swift_Message('Refus demande'))
->setFrom('talanRemote@talan.com')
->setTo($emailUser)
->setBody(
'Bonjour '.$nomUser.', </br> </br> Vos managers ont refusé votre demande de télétravail soumis le </br>'. $date,
  'text/html');
  $message ->addPart(' talentueusement, </br> </br>  <img src="data:image/png;base64, '.$img.'" style=" width:100px">  </br> ', 'text/html');
  $mailer->send($message);
        return new JsonResponse("demande refusée");
}

public function managerPvalidate($id)
    {
        $demande = $this->demandeRespository->find($id);
        $this->remoteWorkflow->apply($demande, 'to_managerProx_ok');
       //  $this->remoteWorkflow->apply($demande, 'to_validateP');
        // $this->remoteWorkflow->apply($demande, 'to_validate');
        if ($demande->getStatus() !== null) {
            $demande->setUpdatedAt(date("Y-m-d H:i"));
        }
       // $this->entityManager->persist($demande);
        $this->entityManager->flush();
        return new JsonResponse($demande);
    }
   
    public function managerEvalidate($id)
    {
        $demande = $this->demandeRespository->find($id);
        $projets=$demande->getProjet();
     //   dd($projets->getManagerProx());
        if(is_null($projets->getManagerProx())==false)
        {  
            $data[0]['managerProx']=$projets->getManagerProx()->getId();
            $this->remoteWorkflow->apply($demande, 'to_managerE_ok');
        }
            else{
               
                $this->remoteWorkflow->apply($demande, 'to_validate_oneManager');
            }
       
 
        if ($demande->getStatus() !== null) {
            $demande->setUpdatedAt(date("Y-m-d H:i"));
        }
      //  $this->entityManager->persist($demande);
        $this->entityManager->flush();
        return new JsonResponse($demande);
    }

    public function validate($id)
    {
        $demande = $this->demandeRespository->find($id);
  
        $this->remoteWorkflow->apply($demande, 'to_validate');
     //   $this->remoteWorkflow->apply($demande, 'to_validateP');
     //   $this->remoteWorkflow->apply($demande, 'to_validateE');
        if ($demande->getStatus() !== null) {
            $demande->setUpdatedAt(date("Y-m-d H:i"));
        }
      //  $this->entityManager->persist($demande);
        $this->entityManager->flush();
//send email from admin to user
$demande = $this->demandeRespository->find($id);
$date=$demande->getCreatedAt();
$emailUser=$demande->getUser()->getEmail();
$nomUser=$demande->getUser()->getNom();
$transport = (new Swift_SmtpTransport('smtp.mailtrap.io', 25))
->setUsername('a500e2fd24237f')
->setPassword('95b4b26917fe57');
$img= base64_encode(file_get_contents('https://static2.clutch.co/s3fs-public/logos/talan_logo.png'));
$mailer = new Swift_Mailer($transport);
$message=(new Swift_Message('validation de la demande'))
->setFrom('talanRemote@talan.com')
->setTo($emailUser)
->setBody(
'Bonjour '.$nomUser.', </br> </br> Vos managers ont validé votre demande de télétravail soumis le </br>'. $date,
  'text/html');
  $message ->addPart(' talentueusement, </br> </br>  <img src="data:image/png;base64, '.$img.'" style=" width:100px">  </br> ', 'text/html');
  $mailer->send($message);

        return new JsonResponse($demande);
    }


    public function validateE($id)
    {
        $demande = $this->demandeRespository->find($id);
  
 
        $this->remoteWorkflow->apply($demande, 'to_validateE');
        if ($demande->getStatus() !== null) {
            $demande->setUpdatedAt(date("Y-m-d H:i"));
        }
      //  $this->entityManager->persist($demande);
        $this->entityManager->flush();
        return new JsonResponse('manager valide');
    }

    public function validateP($id)
    {
        $demande = $this->demandeRespository->find($id);
  
      ///  $this->remoteWorkflow->apply($demande, 'to_validate');
        $this->remoteWorkflow->apply($demande, 'to_validateP');
      //  $this->remoteWorkflow->apply($demande, 'to_validateE');
        if ($demande->getStatus() !== null) {
            $demande->setUpdatedAt(date("Y-m-d H:i"));
        }
    //    $this->entityManager->persist($demande);
        $this->entityManager->flush();
        return new JsonResponse('managerProx valide');
    }

    public function refuse($id)
    {
        $demande = $this->demandeRespository->find($id);
     
            $projets=$demande->getProjet();
            //   dd($projets->getManagerProx());
               if(is_null($projets->getManagerProx())==false)
               {  
                   $data[0]['managerProx']=$projets->getManagerProx()->getId();
                   $this->remoteWorkflow->apply($demande, 'to_refuse');
               }
                   else{
                    $this->remoteWorkflow->apply($demande, 'to_refuse_oneManager');
                   }
        if ($demande->getStatus() !== null) {
            $demande->setUpdatedAt(date("Y-m-d H:i"));
        }
       // $this->entityManager->persist($demande);
        $this->entityManager->flush();

//send email from admin to user
$date=$demande->getCreatedAt();
$emailUser=$demande->getUser()->getEmail();
$nomUser=$demande->getUser()->getNom();
$transport = (new Swift_SmtpTransport('smtp.mailtrap.io', 25))
->setUsername('a500e2fd24237f')
->setPassword('95b4b26917fe57');
$img= base64_encode(file_get_contents('https://static2.clutch.co/s3fs-public/logos/talan_logo.png'));
$mailer = new Swift_Mailer($transport);
$message=(new Swift_Message('Refus demande'))
->setFrom('talanRemote@talan.com')
->setTo($emailUser)
->setBody(
'Bonjour '.$nomUser.', </br> </br> Vos managers ont refusé votre demande de télétravail soumis le </br>'. $date,
  'text/html');
  $message ->addPart(' talentueusement, </br> </br>  <img src="data:image/png;base64, '.$img.'" style=" width:100px">  </br> ', 'text/html');
  $mailer->send($message);

        return new JsonResponse('demande refusée');
    }


    public function refuseE($id)
    {
        $demande = $this->demandeRespository->find($id);
        $this->remoteWorkflow->apply($demande, 'to_refuse_E');
        if ($demande->getStatus() !== null) {
            $demande->setUpdatedAt(date("Y-m-d H:i"));
        }
     //   $this->entityManager->persist($demande);
        $this->entityManager->flush();

//send email from admin to user

$date=$demande->getCreatedAt();
$emailUser=$demande->getUser()->getEmail();
$nomUser=$demande->getUser()->getNom();
$transport = (new Swift_SmtpTransport('smtp.mailtrap.io', 25))
->setUsername('a500e2fd24237f')
->setPassword('95b4b26917fe57');
$img= base64_encode(file_get_contents('https://static2.clutch.co/s3fs-public/logos/talan_logo.png'));
$mailer = new Swift_Mailer($transport);
$message=(new Swift_Message('Refus demande'))
->setFrom('talanRemote@talan.com')
->setTo($emailUser)
->setBody(
'Bonjour '.$nomUser.', </br> </br> Vos managers ont refusé votre demande de télétravail soumis le </br>'. $date,
  'text/html');
  $message ->addPart(' talentueusement, </br> </br>  <img src="data:image/png;base64, '.$img.'" style=" width:100px">  </br> ', 'text/html');
  $mailer->send($message);
  return new JsonResponse('demande refusée');}


  public function refuseP($id)
    {
        $demande = $this->demandeRespository->find($id);
        $this->remoteWorkflow->apply($demande, 'to_refuse_P');
        if ($demande->getStatus() !== null) {
            $demande->setUpdatedAt(date("Y-m-d H:i"));
        }
      //  $this->entityManager->persist($demande);
        $this->entityManager->flush();

//send email from admin to user

$date=$demande->getCreatedAt();
$emailUser=$demande->getUser()->getEmail();
$nomUser=$demande->getUser()->getNom();
$transport = (new Swift_SmtpTransport('smtp.mailtrap.io', 25))
->setUsername('a500e2fd24237f')
->setPassword('95b4b26917fe57');
$img= base64_encode(file_get_contents('https://static2.clutch.co/s3fs-public/logos/talan_logo.png'));
$mailer = new Swift_Mailer($transport);
$message=(new Swift_Message('Refus demande'))
->setFrom('talanRemote@talan.com')
->setTo($emailUser)
->setBody(
'Bonjour '.$nomUser.', </br> </br> Vos managers ont refusé votre demande de télétravail soumis le  </br>'. $date,
  'text/html');
  $message ->addPart(' talentueusement, </br> </br>  <img src="data:image/png;base64, '.$img.'" style=" width:100px">  </br> ', 'text/html');
  $mailer->send($message);

        return new JsonResponse('demande refusée');
    }

    public function cancelvalidationP($id)
    {
        $demande = $this->demandeRespository->find($id);
        $this->remoteWorkflow->apply($demande, 'to_cancel_validationP');
     //   $this->entityManager->persist($demande);
        $this->entityManager->flush();
        return new JsonResponse($demande);
}
public function cancelvalidationP2($id)
    {
        $demande = $this->demandeRespository->find($id);
        $this->remoteWorkflow->apply($demande, 'to_cancel_validationP2');
   //     $this->entityManager->persist($demande);
        $this->entityManager->flush();
        return new JsonResponse($demande);
}
public function cancelvalidationE($id)
    {
        $demande = $this->demandeRespository->find($id);
        $this->remoteWorkflow->apply($demande, 'to_cancel_validationE');
    //    $this->entityManager->persist($demande);
        $this->entityManager->flush();
        return new JsonResponse($demande);
}
public function cancelvalidationE2($id)
    {
        $demande = $this->demandeRespository->find($id);
        $this->remoteWorkflow->apply($demande, 'to_cancel_validationE2');
        $this->entityManager->persist($demande);
        $this->entityManager->flush();
        return new JsonResponse($demande);
}

public function cancelrefusedP($id)
    {
        $demande = $this->demandeRespository->find($id);
        $status=$demande->getStatus();

      // if($status[0]['managerP_pending']==0 && $status[0]['managerE_pending']==1){    
        $this->remoteWorkflow->apply($demande, 'to_cancel_refusedP');
   // }
       // $this->entityManager->persist($demande);
        $this->entityManager->flush();
        return new JsonResponse($demande);
}
public function cancelrefused($id)
    {
        $demande = $this->demandeRespository->find($id);
        $status=$demande->getStatus();

    //    if($status[0]['managerP_pending']==1 && $status[0]['managerE_pending']==1){
        $this->remoteWorkflow->apply($demande, 'to_cancel_refused');
   // }
        $this->entityManager->persist($demande);
        $this->entityManager->flush();
        return new JsonResponse($demande);
}
public function cancelrefusedE($id)
    {
        $demande = $this->demandeRespository->find($id);
        $status=$demande->getStatus();
     //   if($status[0]['managerP_pending']==1 && $status[0]['managerE_pending']==0){  
        $this->remoteWorkflow->apply($demande, 'to_cancel_refusedE');
    //}
        $this->entityManager->persist($demande);
        $this->entityManager->flush();
        return new JsonResponse($demande);
}


public function cancelrefusedManagerOnly($id)
    {
        $demande = $this->demandeRespository->find($id);
        $status=$demande->getStatus();
     //   if($status[0]['managerP_pending']==1 && $status[0]['managerE_pending']==0){  
        $this->remoteWorkflow->apply($demande, 'to_cancelrefuse_oneManager');
    //}
     //   $this->entityManager->persist($demande);
        $this->entityManager->flush();
        return new JsonResponse($demande);
}

public function cancelValidatedManagerOnly($id)
    {
        $demande = $this->demandeRespository->find($id);
        $status=$demande->getStatus();
     //   if($status[0]['managerP_pending']==1 && $status[0]['managerE_pending']==0){  
        $this->remoteWorkflow->apply($demande, 'to_cancelvalidation_oneManager');
    //}
     //   $this->entityManager->persist($demande);
        $this->entityManager->flush();
        return new JsonResponse($demande);
}
public function canceltest($id)
    {
        $demande = $this->demandeRespository->find($id);
        $status=$demande->getStatus();
        dd($status);
        if($status['managerP_pending']==1 && $status['managerE_ok']==1){  
       // $this->remoteWorkflow->apply($demande, 'to_cancelvalidation_oneManager');

    }
     //   $this->entityManager->persist($demande);
        $this->entityManager->flush();
        return new JsonResponse($demande);
}


public function afficherDemandes()
    {  //$user = $this->getUser();
        //dd($user);
        $demandes = $this->demandeRespository->findAll();
        // dd($demandes);
        // $data = array();
        foreach ($demandes as $key => $demande) {
            $data[$key]['id'] = $demande->getId();
            $data[$key]['dateDebut'] = $demande->getDateDebut();
            $data[$key]['dateFin'] = $demande->getDateFin();
            $data[$key]['raison'] = $demande->getRaison();
            $data[$key]['adresse'] = $demande->getAdresse();
            $data[$key]['user'] = $demande->getUser();
            $data[$key]['status'] = $demande->getStatus();
        }
        return new JsonResponse($demandes);
    }



}