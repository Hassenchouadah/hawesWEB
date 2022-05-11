<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\MessageType;
use App\Form\UtilisateurType;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @IsGranted("ROLE_ADMIN", message="No access! Get out!")
 *
 */
class UtilisateurController extends AbstractController
{
    /**
     * @Route("/admin/utilisateurs", name="admin_utilisateurs")
     */
    public function index(): Response
    {

        $users = $this->getDoctrine()->getManager()->getRepository(Utilisateur::class)->findAll();

        return $this->render('utilisateur/index.html.twig', [
            'users' => $users,
            'currentDate' => new \DateTime('now')
        ]);
    }

    /**
    * @Route("/admin/grantRoleAdmin/{id}", name="grantRoleAdmin")
    */
    public function grantRoleAdmin($id): Response
    {
        $user = new Utilisateur();
        $em = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()->getManager()->getRepository(Utilisateur::class)->find($id);
        $user->setRoles(['ROLE_ADMIN']);
        $em->flush();

        return $this->redirectToRoute('admin_utilisateurs');
    }

    /**
    * @Route("/admin/removeRoleAdmin/{id}", name="removeRoleAdmin")
    */
    public function removeRoleAdmin($id): Response
    {
        $user = new Utilisateur();
        $em = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()->getManager()->getRepository(Utilisateur::class)->find($id);
        $user->setRoles(['ROLE_USER']);
        $em->flush();

        return $this->redirectToRoute('admin_utilisateurs');
    }

    /**
     * @Route("/admin/profile/{id}", name="admin_profile")
     */
    public function profile($id,Request $request,UserPasswordEncoderInterface $passwordEncoder){
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->find($id);

        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $user->setMdpUser($passwordEncoder->encodePassword($user, $user->getPassword()));

                $em = $this->getDoctrine()->getManager();
                $em->flush();


        }

        return $this->render('utilisateur/profile.html.twig', [
            'user' => $user,
            'currentDate' => new \DateTime('now'),
            'userform' => $form->createView()
        ]);
    }
}
