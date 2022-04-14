<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Entity\Hebergement;
use App\Reposotory\HebergementRepository;
use App\Form\HebergementType;
use Gedmo\Sluggable\Util\Urlizer;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        $rep = $this->getDoctrine()->getRepository(Hebergement::class);

        $hebergements=$rep->findAll();




        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'hebergements'=>$hebergements
        ]);
    }

     /**
     * @Route("/showback", name="showback")
     */

    public function showback()
    {
        $hebergements=$this->getDoctrine()->getRepository(Hebergement::class)->findAll();
        
       
        return $this->render('backhbg.html.twig', [
            'hebergements' => $hebergements

        ]);

    }


    

        /**
     * @Route("/AddHebergement", name="newhbg")
     * @Route("/edit/{id}", name="edithbg")
     */

    public function form(Hebergement $hbg =null,Request $request, EntityManagerInterface $manager)
    {

        
        if(!$hbg){
            $hbg = new Hebergement();
        }

        $form = $this->createForm(HebergementType::class,$hbg);
        

        $form->handleRequest($request);

        

        if($form->isSubmitted()&& $form->isValid()){
            

            /** @var UploadedFile $UploadedFile */
         $UploadedFile=$form->get('imagee')->getData();

         if($UploadedFile){
         $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
         $originalFilename = pathinfo($UploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
         //$newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$UploadedFile->guessExtension();
         $newFilename = uniqid().'.'.$UploadedFile->guessExtension();
         $UploadedFile->move(
            $destination,
             $newFilename
         );

         $hbg->setImage($newFilename);
        }


            


            $manager->persist($hbg);
            $manager->flush();
             return $this->redirectToRoute('showback');
        }

        return $this->render('Addhbg.html.twig',[
            'formhbg'=>$form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="del_hbg")
     */
    public function delete($id,Request $request, EntityManagerInterface $manager)
    {

        
        $HebergementRepository = $this->getDoctrine()->getRepository(Hebergement::class);

        $hebergement = $HebergementRepository->find($id);
        $manager->remove($hebergement);
        $manager->flush();
       

        
        return $this->redirectToRoute('newhbg', array("actions"=>"delete"));
    }

    
}
