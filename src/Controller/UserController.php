<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/users', name: 'app_user')]
    public function index(Request $request, UserRepository $userRepository): Response
    {   
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        $users = $userRepository->findAll();

        //$users = $userRepository->findAllActive();
        
        return $this->render('user/index.html.twig', [
            'users' => $users,
            'registrationForm' => $form,
        ]);
    }

    #[Route('/users/{id}/show_user', name: 'app_user_show')]
    public function show(User $user): Response
    {   
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/user/{id}/edit', name: 'app_user_edit', methods: ['POST'])]
    public function editar(Request $request, EntityManagerInterface $em, UserRepository $repo, int $id)
    {      
        $user = $repo->find($id);
        $email = $request->request->get('email');
               
        $existe = $repo->findOneBy(['email' => $email]);
        
        if ($existe && $existe->getId() != $user->getId()) {
            $this->addFlash('danger', 'El email "'.$email.'" ya está en uso por otro usuario');            
        }else{
            if($user->getEmail() != $email){
                $user->setEmail($email);
            }            
            $user->setNombre($request->request->get('nombre'));
            $user->setApellido($request->request->get('apellido'));
            $em->flush();
            $this->addFlash('success', 'Usuario actualizado correctamente');
        }       

        return $this->redirectToRoute('app_user');
    }

    #[Route('/users/{id}/status', name: 'app_user_status', methods: ['POST'])]
    public function status(User $user, EntityManagerInterface $em)
    {   
        if($user->getDeletedAt()){
            $this->addFlash('success', 'El Usuario '.$user->getApellido().', '.$user->getNombre().' Activo');
            $user->restore();   
        }else{
            $this->addFlash('success', 'El Usuario '.$user->getApellido().', '.$user->getNombre().' fue Bloqueado con éxito');
            $user->softDelete(); 
        }
        
        $em->flush();       

        return $this->redirectToRoute('app_user');
    }


}
