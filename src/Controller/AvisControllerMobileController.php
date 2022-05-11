<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Repository\AvisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reclamation;
use App\Entity\Type;

use App\Entity\Utilisateurs;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Normalizer;
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


class AvisControllerMobileController extends AbstractController
{
    /**
     * @Route("/avis/controller/mobile", name="app_avis_controller_mobile")
     */
    public function index(): Response
    {
        return $this->render('avis_controller_mobile/index.html.twig', [
            'controller_name' => 'AvisControllerMobileController',
        ]);
    }

/**
       * @Route("/listeavis", name="listeavis")
     */
    public function getReclamation(AvisRepository $repo,SerializerInterface $serializerInterface,NormalizerInterface $Normalizer)
    {
        $avis=$repo->findAll();
        $json=$Normalizer->serialize($avis, 'json');
        /*dump($json);
        die;*/
        //dd($json);
        return new Response($json);
    }




    /**
     * @Route("/addavis/new", name="add_avis")
     
     */
    public function addAvis(Request $request,NormalizerInterface $normalizer)
    {
        
        $avis =new Avis();
        $currentUser = $this->getDoctrine()->getRepository(Utilisateurs::class)->find(21);
        $type = $this->getDoctrine()->getRepository(Type::class)->find(2);
/*
        $description=$request->query->get("desc_rec");
  */
        $avis->setDescAvis($request->get("desc_avis"));
        $em=$this->getDoctrine()->getManager();
        $date=new \DateTime("now");
        /*
        $reclamation->setDescRec($description);
        */
        $avis->setIduser($currentUser);
        $avis->setDateajoutavis($date);
        /*
        $avis->setTraite(0);
        
        */
        $avis->setEtoile(4);

        $em->persist($avis);
        $em->flush();

        $jsonContent=$normalizer->normalize($avis, 'json', ['groups'=>'post:read']);
        return new Response("Avis Added Successfully ".json_encode($jsonContent));

    }

    
    /**
     * @Route("/modifavis/new", name="modif_avis")
     */
    public function modifAvis(Request $request,SerializerInterface $serializerInterface , EntityManagerInterface $em,NormalizerInterface $Normalizer)
    {
        $avis=new Avis();
        
        $em=$this->getDoctrine()->getManager();
        $id=$request->query->get("idAvis");
        $avis=$em->getRepository(Avis::class)->find($id);
        $avis->setDescAvis($request->query->get("descAvis"));
        //$reclamation->setIdRec($id);


        //$reclamation=$em->getRepository(Reclamation::class)->find($id);
        $em->flush();
        return new Response("Information Updated Successfully".json_encode($avis));

    }

    /**
     * @Route("/suppavis/{id}", name="supp_avis")
     */
    public function suppReclamation(Request $request, EntityManagerInterface $em,NormalizerInterface $Normalizer,$id)
    {
        $avis=new Avis();
        $em=$this->getDoctrine()->getManager();
        $avis=$em->getRepository(Avis::class)->find($id);
        $em->remove($avis);
        $em->flush();
        $Content=$Normalizer->normalize($avis,'json',['groups'=>'post:read']);
        return new Response("Avis deleted Successfully".json_encode($Content));

    }










}
