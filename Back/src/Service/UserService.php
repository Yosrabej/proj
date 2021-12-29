<?php

namespace App\Service;


use App\Repository\UserRepository;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Swift_Attachment;


class UserService
{
    protected $entityManager;
    protected $userRepository;
    protected $projetRespository;
    protected $mailer;
    protected $encoder;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository, ProjetRepository $projetRespository, \Swift_Mailer $mailer, UserPasswordEncoderInterface $encoder)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->projetRespository = $projetRespository;
        $this->mailer = $mailer;
        $this->encoder = $encoder;
    }

    public function dashboard()
    {
        $users = $this->userRepository->findBy(array("supprimer" => "non"));
        foreach ($users as $key => $user) {
            $data[$key]['username'] = $user->getUsername();
            $data[$key]['password'] = $user->getPassword();
            $data[$key]['nom'] = $user->getNom();
            $data[$key]['prenom'] = $user->getPrenom();
            $data[$key]['id'] = $user->getId();
        }
        return new JsonResponse($data);
    }

    public function roleUsers($role)
    {
        $users = $this->userRepository->findByExampleField($role);
        if (count($users) >= 1) {
            foreach ($users as $key => $user) {
                $data[$key]['username'] = $user->getUsername();
                $data[$key]['nom'] = $user->getNom();
                $data[$key]['prenom'] = $user->getPrenom();
                $data[$key]['id'] = $user->getId();
                $data[$key]['roles'] = $user->getRoles();
            }
        } else {
            $data[0]['username'] = $users[0]->getUsername();
            $data[0]['nom'] = $users[0]->getNom();
            $data[0]['prenom'] = $users[0]->getPrenom();
            $data[0]['id'] = $users[0]->getId();
            $data[0]['roles'] = $users[0]->getRoles();
        }

        return new JsonResponse($data);
    }

    public function deleteUser($id)
    {
        $user = $this->userRepository->find($id);
        $user->setSupprimer("oui");

        $this->entityManager->merge($user);
        $this->entityManager->flush();

        $data[0]['username'] = $user->getUsername();
        $data[0]['nom'] = $user->getNom();
        $data[0]['prenom'] = $user->getPrenom();
        $data[0]['id'] = $user->getId();
        $data[0]['roles'] = $user->getRoles();
        $data[0]['supprimer'] = $user->getSupprimer();

        return new JsonResponse($data);
    }

    public function findUs($id)
    {
        $user = $this->userRepository->find($id);

        $data[0]['username'] = $user->getUsername();
        $data[0]['nom'] = $user->getNom();
        $data[0]['prenom'] = $user->getPrenom();
        $data[0]['id'] = $user->getId();
        $data[0]['supprimer'] = $user->getSupprimer();
        $data[0]['role'] = $user->getRoles()[0];
        $data[0]['contrat'] = $user->getTypeContrat();
        $data[0]['password'] = $user->getPassword();

        return new JsonResponse($data);
    }


    public function updateUser($id, $data)
    {
        $user = $this->userRepository->find($id);

        $user->setEmail($data['username']);
        $user->setNom($data['nom']);
        $user->setPrenom($data['prenom']);
        $roleArr[] = $data['role'];
        $user->setRoles($roleArr);
        $contrat = $data['contrat'];
        if ($contrat == "true") {
            $user->setTypeContrat(true);
        } else {
            $user->setTypeContrat(false);
        }

        $this->entityManager->merge($user);
        $this->entityManager->flush();

        $data[0]['username'] = $user->getUsername();
        $data[0]['nom'] = $user->getNom();
        $data[0]['prenom'] = $user->getPrenom();
        $data[0]['role'] = $user->getRoles()[0];
        $data[0]['contrat'] = $user->getTypeContrat();

        return new JsonResponse($data);
    }

    public function UsersPagination()
    {
        $pageSize = 5;
        $AllUsers = $this->userRepository->findBy(array("supprimer" => "non"));
        $nombre_total = count($AllUsers);
        $nombre_page = ceil($nombre_total / $pageSize);
        $users = $this->userRepository->getUserByIndex(0);

        foreach ($users as $key => $user) {
            $data[$key]['username'] = $user->getUsername();
            $data[$key]['password'] = $user->getPassword();
            $data[$key]['nom'] = $user->getNom();
            $data[$key]['prenom'] = $user->getPrenom();
            $data[$key]['id'] = $user->getId();
            $data[$key]['nombre_total_page'] = $nombre_page;
        }
        return new JsonResponse($data);
    }

    public function UsersPaginationById($p)
    {

        $pageSize = 5;
        $AllUsers = $this->userRepository->findBy(array("supprimer" => "non"));
        $nombre_total = count($AllUsers);
        $nombre_page = ceil($nombre_total / $pageSize);
        $index = ($p - 1) * $pageSize;

        $users = $this->userRepository->getUserByIndex($index);

        foreach ($users as $key => $user) {
            $data[$key]['username'] = $user->getUsername();
            $data[$key]['password'] = $user->getPassword();
            $data[$key]['nom'] = $user->getNom();
            $data[$key]['prenom'] = $user->getPrenom();
            $data[$key]['id'] = $user->getId();
            $data[$key]['nombre_total_page'] = $nombre_page;
        }

        return new JsonResponse($data);
    }

    public function search($word)
    {
        $users = $this->userRepository->getUsers($word);
        foreach ($users as $key => $user) {
            $data[$key]['username'] = $user->getUsername();
            $data[$key]['nom'] = $user->getNom();
            $data[$key]['prenom'] = $user->getPrenom();
            $data[$key]['id'] = $user->getId();
        }
        return new JsonResponse($data);
    }


    public function contact($id)
    {
        $user = $this->userRepository->find($id);

        // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // $charactersLength = strlen($characters);
        // $randomString = '';
        // for ($i = 0; $i < 15; $i++) {
        //     $randomString .= $characters[rand(0, $charactersLength - 1)];
        // }
        // $message = (new \Swift_Message('Nouveau contact'))
        //     ->setSubject('Réinitialiser votre mot de passe ')
        //     ->setFrom('wiembenameur90@gmail.com')
        //     ->setTo($user->getEmail())
        //     ->setBody('<h1> Salut ' . $user->getNom() .' '. $user->getPrenom() . ',</h1>
        //     <p>Veuillez trouver votre nouveau mot de passe :</p>
        //     <p><Strong> ' . $randomString . '</Strong></p>
        //     <p>Talantueusement,</p>
        //     ******************************************************************', 'text/html')
        //     ->attach(Swift_Attachment::fromPath('http://www.rmconseil.eu/wp-content/uploads/2015/01/logo-fond-TALAN-01-425x450.png'));
        // $this->mailer->send($message);
        // $hash = $this->encoder->encodePassword($user, $randomString);
        // $user->setPassword($hash);

        // $this->entityManager->merge($user);
        // $this->entityManager->flush();

        // $data[0]['nom'] = $user->getUsername();
        // $data[0]['password'] = $user->getPassword();
        // $data[0]['prenom'] = $user->getPrenom();
        // $data[0]['id'] = $user->getId();


        return new JsonResponse($user);
    }
}
