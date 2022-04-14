<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\UtilisateurType;
use App\Entity\Utilisateurs;

use Symfony\Component\HttpFoundation\Request;

class AuthController extends AbstractController
{
    

    /**
     * @Route("/auth/signin", name="auth_siginin")
     */
    public function login(): Response
    {
        return $this->render('auth/login.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

    /**
     * @Route("/auth/signup", name="auth_signup")
     */
    public function signup(Request $request): Response
    {
        $utilisateur=new Utilisateurs();
        $utilisateur->setIsVerified(0);
        $form=$this->createForm(UtilisateurType::class,$utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid())/*verifier */
        {
            $em=$this->getDoctrine()->getManager();
            $utilisateur->setRole('User');
            $em->persist($utilisateur);
            $em->flush();
            return $this->redirectToRoute('auth_users');
        }

        return $this->render('auth/create.html.twig', [
            'userform'=>$form->createView()
        ]);
    }
       /**
        *@Route("/deletebyid/{id}", name="deletebyids")
     */

    public function DeleteUser($id)
    {
        $repository=$this->getDoctrine()->getRepository(Utilisateurs::class);
        $entityManager = $this->getDoctrine()->getManager();
        $user=$repository->find($id);
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute('listUsers');
        
    }


     /**
     * @Route("/authUpdate/{id}", name="authUpdate")
     */

    public function UpdateUser(Request $request,int $id)

    {   
        $repository=$this->getDoctrine()->getRepository(Utilisateurs::class);
        $user=$repository->find($id);
        $form= $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);
       
        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('listUsers');

        }
        return $this->render('auth/update.html.twig', ['UpdateForm' => $form->createView()]);


    }
    /**
     * @Route("/admin/profile/{id}", name="admin_profile")
     */
    public function profile($id,Request $request){
        $user = $this->getDoctrine()->getRepository(Utilisateurs::class)->find($id);

        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {


                $em = $this->getDoctrine()->getManager();
                $em->flush();


        }

        return $this->render('auth/profile.html.twig', [
            'user' => $user,
            'currentDate' => new \DateTime('now'),
            'userform' => $form->createView()
        ]);
    }
    /**
     * @Route("/admin/utilisateurs", name="admin_utilisateurs")
     */
    public function index(): Response
    {

        $users = $this->getDoctrine()->getManager()->getRepository(Utilisateurs::class)->findAll();

        return $this->render('auth/index.html.twig', [
            'users' => $users,
            'currentDate' => new \DateTime('now')
        ]);
    }

/**
    * @Route("/admin/grantRoleAdmin/{id}", name="grantRoleAdmin")
    */
    public function grantRoleAdmin($id): Response
    {
        $user = new Utilisateurs();
        $em = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()->getManager()->getRepository(Utilisateurs::class)->find($id);
        $user->setRole('ADMIN');
        $em->flush();

        return $this->redirectToRoute('admin_utilisateurs');
    }
    /**
    * @Route("/admin/removeRoleAdmin/{id}", name="removeRoleAdmin")
    */
    public function removeRoleAdmin($id): Response
    {
        $user = new Utilisateurs();
        $em = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()->getManager()->getRepository(Utilisateurs::class)->find($id);
        $user->setRole('USER');
        $em->flush();

        return $this->redirectToRoute('admin_utilisateurs');
    }
    }

