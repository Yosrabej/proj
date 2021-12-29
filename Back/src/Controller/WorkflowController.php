<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\WorkflowService;

class WorkflowController extends AbstractController
{
 
    /**
     * @Route("api/request/{id}/{userId}/{projId}", name="request")
     */
    public function request($id, $userId, $projId, WorkflowService $workflowService)
    {
        $workflowService->request($id, $userId,$projId); 
        return new JsonResponse("demande envoyée");
    }

  /**
     * @Route("/api/refuseA/{id}/{userId}")
     */
    public function refuseA($id, $userId, WorkflowService $workflowService)
    {
        $workflowService->refuseA($id, $userId);
        return new JsonResponse("demande refusée");
    }


    /**
     * @Route("/api/managerPvalidate/{id}", name="managerPvalidate")
     */
    public function managerPvalidate($id, WorkflowService $workflowService)
    {
        $workflowService->managerPvalidate($id);
        return new JsonResponse('demande validée par managerProx');
    }

    /**
     * @Route("/api/managerEvalidate/{id}", name="managerEvalidate")
     */
    public function managerEvalidate($id, WorkflowService $workflowService)
    {
        $workflowService->managerEvalidate($id);
        return new JsonResponse('demande validée par managerE');
    }

    /**
     * @Route("api/validate/{id}", name="validate")
     */
    public function validate($id, WorkflowService $workflowService)
    {
        $workflowService->validate($id);
        return new JsonResponse('demande validée par les deux managers');
    }


  /**
     * @Route("api/validateE/{id}", name="validateE")
     */
    public function validateE($id, WorkflowService $workflowService)
    {
   $workflowService->validateE($id);
        return new JsonResponse('manager valide');
    }
  /**
     * @Route("api/validateP/{id}", name="validateP")
     */
    public function validateP($id, WorkflowService $workflowService)
    {
        $workflowService->validateP($id);
        return new JsonResponse('managerProx valide');
    }


    /**
     * @Route("/api/refuse/{id}")
     */
    public function refuse($id, WorkflowService $workflowService)
    {
        $workflowService->refuse($id);

        return new JsonResponse('demande refusée');
    }

    /**
     * @Route("/api/refuseE/{id}")
     */
    public function refuseE($id, WorkflowService $workflowService)
    {
        $workflowService->refuseE($id);

        return new JsonResponse('demande refusée');
    }


 /**
     * @Route("/api/refuseP/{id}")
     */
    public function refuseP($id,WorkflowService $workflowService)
    {
        $workflowService->refuseP($id);

        return new JsonResponse('demande refusée');
    }


 /**
     * @Route("/api/cancelvalidationP/{id}", name="cancel")
     */
    public function cancelvalidationP($id, WorkflowService $workflowService)
    {
        $workflowService->cancelvalidationP($id);
        return new JsonResponse('cancelled');
    }
 /**
     * @Route("/api/cancelvalidationP2/{id}", name="cancelP2")
     */
    public function cancelvalidationP2($id, WorkflowService $workflowService)
    {
        $workflowService->cancelvalidationP2($id);
        return new JsonResponse('cancelled');
    }

/**
     * @Route("/api/cancelvalidationE/{id}")
     */
    public function cancelvalidationE($id, WorkflowService $workflowService)
    {
        $workflowService->cancelvalidationE($id);
        return new JsonResponse('cancelled');
    }
 /**
     * @Route("/api/cancelvalidationE2/{id}")
     */
    public function cancelvalidationE2($id, WorkflowService $workflowService)
    {
        $workflowService->cancelvalidationE2($id);
        return new JsonResponse('cancelled');
    }
     /**
     * @Route("/api/cancelrefused/{id}")
     */
    public function cancelrefused($id, WorkflowService $workflowService)
    {
        $workflowService->cancelrefused($id);
        return new JsonResponse('cancelled');
    }
       /**
     * @Route("/api/cancelrefusedP/{id}")
     */
    public function cancelrefusedP($id, WorkflowService $workflowService)
    {
        $workflowService->cancelrefusedP($id);
        return new JsonResponse('cancelled');
    }
    /**
     * @Route("/api/cancelrefusedE/{id}")
     */
    public function cancelrefusedE($id, WorkflowService $workflowService)
    {
        $workflowService->cancelrefusedE($id);
        return new JsonResponse('cancelled');
    }
/**
     * @Route("/api/cancelrefusedManagerOnly/{id}")
     */
    public function cancelrefusedManagerOnly($id, WorkflowService $workflowService)
    {
        $workflowService->cancelrefusedManagerOnly($id);
        return new JsonResponse('cancelled');
    }
   
/**
     * @Route("/api/cancelvalidatedManagerOnly/{id}")
     */
    public function cancelvalidatedManagerOnly($id, WorkflowService $workflowService)
    {
        $workflowService-> cancelValidatedManagerOnly($id);
        return new JsonResponse('cancelled');
    }
/**
     * @Route("/api/canceltest/{id}")
     */
    public function canceltest($id, WorkflowService $workflowService)
    {
        $workflowService-> canceltest($id);
        return new JsonResponse('cancelled');
    }
    /**
     * @Route("/api/demandes" , name="demandes")
     */
    public function afficherDemandes(WorkflowService $workflowService)
    {  $workflowService->afficherDemandes();
        return new JsonResponse('demandes affichées');
    }
}
