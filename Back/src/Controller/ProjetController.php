<?php

namespace App\Controller;

use App\Service\ProjectService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;





class ProjetController extends AbstractController
{

    /**
     * @Route("/api/create")
     */
    public function createProject(Request $request, ProjectService $projectService)
    {
        $data = json_decode($request->getContent(), true);
        return new JsonResponse($projectService->createProject($data));
    }




    /**
     * @Route("/api/projects")
     */
    public function getProjects(ProjectService $projectService)
    {

        return ($projectService->getProjects());
    }


    /**
     * @Route("/api/project/{id}")
     */
    public function getProject($id, ProjectService $projectService)
    {
        return ($projectService->getProjectById($id));
    }




    /**
     * @Route("/api/update/{id}")
     */

    public function updateProject($id, Request $request, ProjectService $projectService)
    {
        $data = json_decode($request->getContent(), true);
        return ($projectService->updateProject($id, $data));
    }



    /**
     * @Route("/api/delete/{id}")
     */
    public function deleteProject($id, ProjectService $projectService)
    {
        return new JsonResponse($projectService->deleteProject($id));
    }


    /**
     * @Route("/api/pagination")
     */
    public function ProjectsPagination(ProjectService $projectService)
    {
        return ($projectService->ProjectsPagination());
    }


    /**
     * @Route("/api/pagination/{p}")
     */
    public function ProjectsPaginationById($p, ProjectService $projectService)
    {

        return ($projectService->ProjectsPaginationById($p));
    }

    /**
     * @Route("/api/searchProject/{word}")
     */
    public function search($word, ProjectService $projectService)
    {
        return ($projectService->search($word));
    }
}
