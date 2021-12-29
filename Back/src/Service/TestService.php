<?php
namespace App\Service;

use App\Entity\Demande;

use App\Repository\DemandeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class TestService{
    protected $entityManager;
    protected $userRepository;
    protected $demandeRespository;
    public $remoteWorkflow;
    public function __construct(WorkflowInterface $remoteWorkflow, EntityManagerInterface $entityManager, UserRepository $userRepository, DemandeRepository $demandeRespository)
    {
    $this->remoteWorkflow = $remoteWorkflow;
    $this->entityManager = $entityManager;
    $this->userRepository = $userRepository;
    $this->demandeRespository = $demandeRespository;
    }
public function wk($id, $userId, $transition){
    $demande = $this->demandeRespository->find($id);
        $user = $this->userRepository->find($userId);
        $this->remoteWorkflow->apply($demande, $transition);
        $this->entityManager->persist($demande);
        $this->entityManager->flush();
}


}