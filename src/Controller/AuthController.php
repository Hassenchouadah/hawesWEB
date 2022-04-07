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
     * @Route("/auth/users", name="auth_users")
     */
    public function index(): Response
    {
        return $this->render('auth/index.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

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
            $em->persist($utilisateur);
            $em->flush();
            return $this->redirectToRoute('auth_users');
        }

        return $this->render('auth/create.html.twig', [
            'userform'=>$form->createView()
        ]);
    }
}
