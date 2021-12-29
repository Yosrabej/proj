<?php

namespace App\Service;

use App\Entity\Projet;

use App\Repository\ProjetRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;




class ProjectService
{
    protected $entityManager;
    protected $userRepository;
    protected $projetRespository;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository, ProjetRepository $projetRespository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->projetRespository = $projetRespository;
    }
    public function createProject($data)
    {
        $project = new Projet();
        $project->setNom($data['nom']);
        $collaborators = $data['collab'];
        foreach ($collaborators as $collaborator) {
            $collabObject = $this->userRepository->find($collaborator['id']);
            if ($collabObject) {
                $project->addCollaborateur($collabObject);
            }
        }
        $manager = $data['manager'][0];
        $managerObject = $this->userRepository->find($manager['id']);
        if ($managerObject) {
            $project->setManager($managerObject);
        }


        // if ($data['managerprox'][0]['id']) {
        //     $proxyManager = $data['managerprox'][0];
        //     $proxyManagerObject = $this->userRepository->find($proxyManager['id']);
        //     if ($proxyManagerObject) {
        //         $project->setManagerProx($proxyManagerObject);
        //     }
        // }

        $project->setSurSite($data['surSite']);
        $project->setSupprimer("non");
        $this->entityManager->persist($project);
        $this->entityManager->flush();
        return $project->getId();
    }
    public function showUsers($data)
    {
        $projects = $this->projetRespository->findAll();
        foreach ($projects as $key => $project) {
            $data[$key]['nom'] = $project->getNom();
            $data[$key]['surSite'] = $project->getSurSite();
            $data[$key]['id'] = $project->getId();
        }
        return new JsonResponse($data);
    }


    public function updateProject($id, $data)
    {
        $oldCollab = $this->projetRespository->find($id)->getCollaborateur();


        $project = $this->projetRespository->find($id);

        foreach ($oldCollab as $key => $collab) {
            $ArrOldCollab[$key]['id'] = $collab->getId();
            $ArrOldCollab[$key]['username'] = $collab->getUsername();
        }

        $project->setNom($data['nom']);
        $collaborators = $data['collab'];

        foreach ($collaborators as $collaborator) {

            if (!in_array($collaborator, $ArrOldCollab)) {
                $collabObject = $this->userRepository->find($collaborator['id']);
                if ($collabObject) {
                    $project->addCollaborateur($collabObject);
                    $added_collab[] =  $collabObject->getUsername();
                }
            }
        }

        foreach ($ArrOldCollab as $oldCollab) {
            if (!in_array($oldCollab, $collaborators)) {
                $collabObject = $this->userRepository->find($oldCollab['id']);
                if ($collabObject) {
                    $project->removeCollaborateur($collabObject);
                    $removed_collab[] =  $collabObject->getUsername();
                }
            }
        }

        $manager = $data['manager'][0];
        $managerObject = $this->userRepository->find($manager['id']);
        if ($managerObject) {
            $project->setManager($managerObject);
        }


        if ($data['managerprox'] !== null && $data['managerprox'] !== []) {
            $proxyManager = $data['managerprox'][0];
            $proxyManagerObject = $this->userRepository->find($proxyManager['id']);
            if ($proxyManagerObject) {
                $project->setManagerProx($proxyManagerObject);
            }
        }

        if ($data['managerprox'] == null) {
            $project->setManagerProx(null);
        }



        // if ($data['managerprox']!==[]) {
        //     $proxyManager = $data['managerprox'][0];
        //     $proxyManagerObject = $this->userRepository->find($proxyManager['id']);
        //     if ($proxyManagerObject) {
        //         $project->setManagerProx($proxyManagerObject);
        //     }
        // }


        // if ($data['managerprox']) {
        //     $proxyManager = $data['managerprox'][0];
        //         $project->setManagerProx($proxyManagerObject);
        // }





        $project->setSurSite($data['surSite']);



        $this->entityManager->merge($project);
        $this->entityManager->flush();



        $data[0]['nom'] = $project->getNom();
        $data[0]['id'] = $project->getId();
        $data[0]['manager'] = $project->getManager()->getId();
        if ($project->getManagerProx() && $project->getManagerProx()->getId()) {
            $data[0]['managerProx'] = $project->getManagerProx()->getId();
        }
        $data[0]['surSite'] = $project->getSurSite();
        $data[0]['collaborateur'] = $project->getCollaborateur();
        $collaborateurs = $project->getCollaborateur();
        foreach ($collaborateurs as $key => $collaborateur) {
            $data[0]['collaborateur'][] = $collaborateur->getUsername();
        }
        return new JsonResponse($data);
    }


    public function getProjects()
    {
        $projects = $this->projetRespository->findBy(array("supprimer" => "non"));
        if ($projects) {
            foreach ($projects as $key => $project) {
                $data[$key]['nom'] = $project->getNom();
                $data[$key]['id'] = $project->getId();
                $data[$key]['manager'] = $project->getManager()->getId();
                if ($project->getManagerProx()) {
                    $data[$key]['managerProx'] = $project->getManagerProx()->getId();
                }
                $data[$key]['surSite'] = $project->getSurSite();
                $collaborateurs = $project->getCollaborateur();
                foreach ($collaborateurs as $collaborateur) {
                    $data[$key]['collaborateur'][] = $collaborateur->getId();
                }
            }
        }
        return new JsonResponse($data);
    }


    public function getProjectById($id)
    {
        $project = $this->projetRespository->find($id);
        $data[0]['nom'] = $project->getNom();
        $data[0]['id'] = $project->getId();
        $data[0]['manager'][0]['username'] = $project->getManager()->getUsername();
        $data[0]['manager'][0]['id'] = $project->getManager()->getId();
        if ($project->getManagerProx()) {
            $data[0]['managerProx'][0]['username'] = $project->getManagerProx()->getUsername();
            $data[0]['managerProx'][0]['id'] = $project->getManagerProx()->getId();
        }
        $data[0]['surSite'] = $project->getSurSite();
        $collaborateurs = $project->getCollaborateur();
        foreach ($collaborateurs as $key => $collaborateur) {
            $data[0]['collaborateur'][$key]['username'] = $collaborateur->getUsername();
            $data[0]['collaborateur'][$key]['id'] = $collaborateur->getId();
        }
        return new JsonResponse($data);
    }



    public function deleteProject($id)
    {
        $project = $this->projetRespository->find($id);
        $project->setSupprimer("oui");

        $this->entityManager->merge($project);
        $this->entityManager->flush();

        $data[0]['nom'] = $project->getNom();
        $data[0]['id'] = $project->getId();
        $data[0]['manager'] = $project->getManager()->getId();
        if ($project->getManagerProx()) {
            $data[0]['managerProx'] = $project->getManagerProx()->getId();
        }

        $data[0]['surSite'] = $project->getSurSite();
        $data[0]['supprimer'] = $project->getSupprimer();

        return new JsonResponse($data);
    }


    public function ProjectsPagination()
    {
        $pageSize = 5;
        $AllProjects = $this->projetRespository->findBy(array("supprimer" => "non"));
        $nombre_total = count($AllProjects);
        $nombre_page = ceil($nombre_total / $pageSize);
        $projects = $this->projetRespository->getProjectByIndex(0);

        foreach ($projects as $key => $project) {
            $data[$key]['nom'] = $project->getNom();
            $data[$key]['id'] = $project->getId();
            $data[$key]['manager'] = $project->getManager()->getId();
            if ($project->getManagerProx()) {
                $data[$key]['managerProx'] = $project->getManagerProx()->getId();
            }
            $data[$key]['surSite'] = $project->getSurSite();
            $data[$key]['nombre_total_page'] = $nombre_page;
            $collaborateurs = $project->getCollaborateur();
            foreach ($collaborateurs as $collaborateur) {
                $data[$key]['collaborateur'][] = $collaborateur->getId();
            }
        }
        return new JsonResponse($data);
    }


    public function ProjectsPaginationById($p)
    {

        $pageSize = 5;
        $AllProjects = $this->projetRespository->findBy(array("supprimer" => "non"));
        $nombre_total = count($AllProjects);
        $nombre_page = ceil($nombre_total / $pageSize);
        $index = ($p - 1) * $pageSize;

        $projects = $this->projetRespository->getProjectByIndex($index);
        foreach ($projects as $key => $project) {
            $data[$key]['nom'] = $project->getNom();
            $data[$key]['id'] = $project->getId();
            $data[$key]['manager'] = $project->getManager()->getId();
            if ($project->getManagerProx()) {
                $data[$key]['managerProx'] = $project->getManagerProx()->getId();
            }
            $data[$key]['surSite'] = $project->getSurSite();
            $data[$key]['nombre_total_page'] = $nombre_page;
            $collaborateurs = $project->getCollaborateur();
            foreach ($collaborateurs as $collaborateur) {
                $data[$key]['collaborateur'][] = $collaborateur->getId();
            }
        }

        return new JsonResponse($data);
    }


    public function search($word)
    {
        $projects = $this->projetRespository->getFilteredProjects($word);

        foreach ($projects as $key => $project) {
            $data[$key]['nom'] = $project->getNom();
            $data[$key]['id'] = $project->getId();
            $data[$key]['manager'] = $project->getManager()->getId();
            if ($project->getManagerProx()) {
                $data[$key]['managerProx'] = $project->getManagerProx()->getId();
            }
            $data[$key]['surSite'] = $project->getSurSite();
            $collaborateurs = $project->getCollaborateur();
            foreach ($collaborateurs as $collaborateur) {
                $data[$key]['collaborateur'][] = $collaborateur->getId();
            }
        }
        return new JsonResponse($data);
    }
}
