<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateurs;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Normalizer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraint\Json;
use Twilio\Serialize;
use Symfony\Component\Mime\Email;

class ReclamationControllerMobileController extends AbstractController
{
    /**
     * @Route("/reclamation/controller/mobile", name="app_reclamation_controller_mobile")
     */
    public function index(): Response
    {
        return $this->render('reclamation_controller_mobile/index.html.twig', [
            'controller_name' => 'ReclamationControllerMobileController',
        ]);
    }

/**
     * @Route("/listeRec", name="listeRec")
     */
    public function getReclamation(ReclamationRepository $repo,SerializerInterface $serializerInterface,NormalizerInterface $Normalizer)
    {
        $reclamation=$repo->findAll();
        $json=$Normalizer->serialize($reclamation, 'json');
        /*dump($json);
        die;*/
        //dd($json);
        return new Response($json);
    }

    /**
     * @Route("/addrec/new", name="add_rec")
     
     */
    public function addReclamation(Request $request,NormalizerInterface $normalizer,MailerInterface $mailer)
    {
        
        $reclamation =new Reclamation();
        $currentUser = $this->getDoctrine()->getRepository(Utilisateurs::class)->find(21);
        $type = $this->getDoctrine()->getRepository(Type::class)->find(2);
/*
        $description=$request->query->get("desc_rec");
  */
        $reclamation->setDescRec($request->get("desc_rec"));
        $em=$this->getDoctrine()->getManager();
        $date=new \DateTime("now");
        /*
        $reclamation->setDescRec($description);
        */
        $reclamation->setDateajoutrec($date);
        $reclamation->setTraite(0);
        $reclamation->setIduser($currentUser);
        $reclamation->setType($type);
        $email = (new Email())
        ->from('hawes@adm.in')
        ->to("mohamedbenhamida10@gmail.com")
        //->cc('cc@example.com')
        //->bcc('bcc@example.com')
        //->replyTo('fabien@example.com')
        //->priority(Email::PRIORITY_HIGH)
        ->subject('Reclamation traité!')
        ->text('Votre reclamation a ete traite, Merci')
        ->html('<p>Votre reclamation a ete traite,</p> <br> <p>Merci</p> ');
    $mailer->send($email);
        $em->persist($reclamation);
        $em->flush();

        $jsonContent=$normalizer->normalize($reclamation, 'json', ['groups'=>'post:read']);
        return new Response("Reclamation Added Successfully ".json_encode($jsonContent));
/*
        $serializer= new Serialize([new ObjectNormalizer()]);
        $formatted =$serializer->normalize($reclamation);
        return new JsonResponse($formatted);
        */
/*
return new Response("okok");
*/


        /*
        $em=$this->getDoctrine()->getManager();
        $reclamation=new Reclamation();
        $reclamation->setDescRec($request->get('desc_rec'));
        $em->persist($reclamation);
        $em->flush();
        $Content=$Normalizer->normalize($reclamation,'json',['groups'=>'post:read']);
        return new Response(json_encode($Content));
*/

        /*
$content=$request->getContent();
        $data=$serializerInterface->deserialize($content,Reclamation::class,'json');
       $em->persist($data);
       $em->flush();
        return new Response('Reclamation added succ');
    */
    }

    
    /**
     * @Route("/modifrec/new", name="modif_rec")
     */
    public function modifReclamation(Request $request,SerializerInterface $serializerInterface , EntityManagerInterface $em,NormalizerInterface $Normalizer)
    {
        $reclamation=new Reclamation();
        
        $em=$this->getDoctrine()->getManager();
        $id=$request->query->get("idrec");
        $reclamation=$em->getRepository(Reclamation::class)->find($id);
        $reclamation->setDescRec($request->query->get("desc_rec"));
        //$reclamation->setIdRec($id);


        //$reclamation=$em->getRepository(Reclamation::class)->find($id);
        $em->flush();
        return new Response("Information Updated Successfully".json_encode($reclamation));

    }

    /**
     * @Route("/supprec/{id}", name="supp_rec")
     */
    public function suppReclamation(Request $request, EntityManagerInterface $em,NormalizerInterface $Normalizer,$id)
    {
        $reclamation=new Reclamation();
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->find($id);
        $em->remove($reclamation);
        $em->flush();
        $Content=$Normalizer->normalize($reclamation,'json',['groups'=>'post:read']);
        return new Response("reclamation deleted Successfully".json_encode($Content));

    }

}
