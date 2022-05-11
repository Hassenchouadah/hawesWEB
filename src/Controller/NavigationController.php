<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class NavigationController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function home()
    {
        $utilisateur = $this->getUser();

        if($utilisateur && in_array('ROLE_ADMIN', $utilisateur->getRoles())){
            return $this->redirectToRoute('admin_home');
        }


        return $this->render('navigation/index.html.twig');
    }


    /**
     * @Route("/admin", name="admin_home")
     */
    public function admin()
    {
        $utilisateur = $this->getUser();

        if(!($utilisateur && in_array('ROLE_ADMIN', $utilisateur->getRoles()))){
            return $this->redirectToRoute('app_home');
        }
        return $this->render('navigation/admin.html.twig');
    }

}