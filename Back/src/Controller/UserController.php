<?php

namespace App\Controller;


use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class UserController extends AbstractController
{
    /**
     * @Route("/api/login_check", name="api/login_check")
     */
    public function loginAction()
    {
        return $this->render('user/login.html.twig');
    }

    /**

     * @Route("/api/register")

     * @param Request $request

     */

    public function create(Request $request, UserPasswordEncoderInterface $encoder)

    {

        $user = new User();

        $data = json_decode($request->getContent(), true);

        $hash = $encoder->encodePassword($user, $data['password']);

        $user->setPassword($hash);

        $user->setNom($data['nom']);

        $user->setPrenom($data['prenom']);

        $user->setEmail($data['email']);

        $rol[] = $data['roles'];

        $user->setRoles($rol);

        $user->setSupprimer("non");

        if ($data['typecontrat'] == "Intercontrat") {

            $user->setTypeContrat($data['typecontrat'] = 0);

        }

        //dd($data['typecontrat']) ;

        $user->setTypeContrat($data['typecontrat']);

        $em = $this->getDoctrine()->getManager();

        $em->persist($user);

        $em->flush();



        return new JsonResponse($data);


    }

     

        
      

    /**
     * @Route("/api/getUserData")
     */
    public function getUserData(Request $request)
    {
        
       
        $data = ($request->getContent());
        
            $userdata = $this->getDoctrine()
            ->getRepository(User::class)
            ->findBy(array('email' => $data));          
            $result[0]['nom'] = $userdata[0]->getNom();
            $result[0]['prenom'] = $userdata[0]->getPrenom();            
            $result[0]['id'] = $userdata[0]->getId();
            $result[0]['email'] = $userdata[0]->getEmail();
            $result[0]['typeContrat'] = $userdata[0]->getTypeContrat();
            $role = $userdata[0]->getRoles();
            $result[0]['roles']= $role[0];
            $result[0]['username'] =  $result[0]['prenom'].' '.$result[0]['nom'];
            return new JsonResponse($result);
    }

    
 /**
     * @Route("/api/users")
     */
    public function dashboard(UserService $userService, UserRepository $userRepository)
    {
        // return ($userService->dashboard());
        $users = $userRepository->findBy(array("supprimer" => "non"));
        foreach ($users as $key => $user) {
            $data[$key]['username'] = $user->getUsername();
            $data[$key]['password'] = $user->getPassword();
            $data[$key]['nom'] = $user->getNom();
            $data[$key]['prenom'] = $user->getPrenom();
            $data[$key]['id'] = $user->getId();
        }
        return new JsonResponse($data);
    }




    /**
     * @Route("/api/{role}/users")
     */
    public function roleUsers(UserService $userService, $role)
    {
        return ($userService->roleUsers($role));
    }




    /**
     * @Route("/api/deleteUser/{id}")
     */
    public function deleteUser($id, UserService $userService)
    {
        return ($userService->deleteUser($id));
    }




    /**
     * @Route("/api/user/{id}")
     */
    public function findUs($id, UserService $userService)
    {
        return ($userService->findUs($id));
    }




    /**
     * @Route("/api/update/user/{id}")
     */
    public function updateUser($id, Request $request, UserService $userService)
    {
        $data = json_decode($request->getContent(), true);
        return ($userService->updateUser($id, $data));
    }


    /**
     * @Route("/api/Userpagination")
     */
    public function UsersPagination(UserService $userService)
    {
        return ($userService->UsersPagination());
    }


    /**
     * @Route("/api/Userpagination/{p}")
     */
    public function ProjectsPaginationById($p, UserService $userService)
    {
        return ($userService->UsersPaginationById($p));
    }

    /**
     * @Route("/api/search/{word}")
     */
    public function search($word, UserService $userService)
    {
        return ($userService->search($word));
    }


    /**
     * @Route("api/resetPassword/{id}")
     */
    public function contact($id, UserService $userService)
    {
        return ($userService->contact($id));
    }
}
