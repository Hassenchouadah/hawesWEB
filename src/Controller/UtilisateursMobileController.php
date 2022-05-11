<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
/**
 * @IsGranted("IS_AUTHENTICATED_ANONYMOUSLY")
 */
class UtilisateursMobileController extends AbstractController
{
    /**
     * @Route("/utilisateurs/mobile", name="app_utilisateurs_mobile")
     */
    public function index(): Response
    {
        return $this->render('utilisateurs_mobile/index.html.twig', [
            'controller_name' => 'UtilisateursMobileController',
        ]);
    }

    /**
     * @Route("/mobile/utilisateurs", name="mobile_utilisateurs")
     */
    public function afficherUtilisateurs(NormalizerInterface $normalizer)
    {
        $repository=$this->getDoctrine()->getRepository(Utilisateur::class);
        $users=$repository->findAll();
        $json=$normalizer->normalize($users, 'json' ,['groups'=>'post:read']);
        return new Response(json_encode($json));
    }


    /**
     * @Route("/mobile/AddUser", name="add_utilisateurs")
     */
    public function ajouterUtilisateur(Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $content = $request->getContent();
        $data = $serializer->deserialize($content,Utilisateur::class,'json');
        $data->setUpdatedAt(new \DateTime('now'));
        $em->persist($data);
        $em->flush();
        return new Response ("User added Successfully");

    }
    /**
     * @Route("/mobile/UpdateUser/{id}", name="update_utilisateurs")
     */
    public function modifierUtilisateur(Request $request, NormalizerInterface $Normalizer, $id) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(utilisateur::class)->find($id);
        $user->setemail($request->get('email'));
        $user->setcin($request->get('cin'));
        $em->flush();
        $jsonContent = $Normalizer->normalize($user,'json',['groups'=>'post:read']);
        return new Response ("information updated successfully".json_encode($jsonContent));
    }
    /**
     * @Route("/mobile/DeleteUser/{id}", name="delete_utilisateur")
     */
    public function deleteUser(Request $request, NormalizerInterface $Normalizer, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(Utilisateur::class)->find($id);
        $em->remove($user);
        $em->flush();
        $jsonContent= $Normalizer->normalize($user, 'json', ['groups'=>'post:read']);
        return new Response("Utilisateur supprimee avec success!".json_encode($jsonContent));
    }

    /**
     * @Route("/mobile/signupMobile", name="api_signup")
     */
    public function signup(Request $request , UserPasswordEncoderInterface $passwordEncoder)
    {
        $email = $request->query->get("email");
        $cin = $request->query->get("cin");
        $nomUser = $request->query->get("nomUser");
        $mdpUser = $request->query->get("mdpUser");
        $prenomUser = $request->query->get("prenomUser");
        $telUser = $request->query->get("telUser");
        $adresseUser = $request->query->get("adresseUser");
        $voiture = $request->query->get("voiture");
        $image = $request->query->get("image");


        $user= new Utilisateur();
        $user->setemail($email);
        $user->setcin($cin);
        $user->setnomUser($nomUser);
        $user->setprenomUser($prenomUser);
        $user->setmdpUser($passwordEncoder->encodePassword($user,$mdpUser));
        $user->setRoles(['ROLE_USER']);
        $user->setadresseUser($adresseUser);
        $user->settelUser($telUser);
        $user->setvoiture($voiture);
        $user->setUpdatedAt(new \DateTime('now'));
        $user->setimage($image);

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return new JsonResponse("account is created" , 200);
        }catch (\Exception $ex){
            return new Response("exeception".$ex->getMessage());
        }

    }

    /**
     * @Route("/mobile/signinMobile", name="api_signin")
     */
    public function signin(Request $request)
    {
        $email = $request->query->get("email");
        $password = $request->query->get("mdpUser");
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(Utilisateur::class)->findOneBy(['email'=>$email]);

        if ($user){
            if (password_verify($password,$user->getPassword())){
                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize($user);
                return new JsonResponse($formatted);
            }
            else {
                return new Response("failed ");
            }
        }
        else{
            return new Response("failed");
        }
    }
}