<?php

namespace App\Controller;

use App\Entity\Hebergement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;




use Dompdf\Dompdf;
use Dompdf\Options;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Utilisateur;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Entity\Categorie;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Bundle\PaginatorBundle\KnpPaginatorBundle;
use App\Repository\UtilisateurRepository;
use App\Repository\HebergementRepository;
use App\Form\HebergementType;
use Gedmo\Sluggable\Util\Urlizer;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_index")
     */
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }

    /**
     * @Route("/hebergement", name="app_Hebergement")
     */
    public function indexHebergement(Request $request,PaginatorInterface $paginator): Response
    {
        $rep = $this->getDoctrine()->getRepository(Hebergement::class);

        $donne=$rep->findAll();


        $hebergements=$paginator->paginate(
            $donne,
            $request->query->getInt('page',1),
            4

        );






        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'hebergements'=>$hebergements
        ]);
    }

    /**
     * @Route("/hebergement", name="redirect")
     */
    public function indexx(Request $request,PaginatorInterface $paginator,$donne): Response
    {




        $hebergements=$paginator->paginate(
            $donne,
            $request->query->getInt('page',1),
            4

        );





        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'hebergements'=>$hebergements
        ]);
    }



    /**
     * @Route("/showback", name="showback")
     */

    public function showback(Request $request,PaginatorInterface $paginator)
    {
        $donne=$this->getDoctrine()->getRepository(Hebergement::class)->findAll();
        $hebergements=$paginator->paginate(
            $donne,
            $request->query->getInt('page',1),
            4

        );

        return $this->render('backhbg.html.twig', [
            'hebergements' => $hebergements

        ]);

    }

    /**
     * @Route("/AddHebergement", name="newhbg")
     * @Route("/edit/{id}", name="edithbg")
     */

    public function form(Hebergement $hbg =null,Request $request, EntityManagerInterface $manager,FlashyNotifier $flashy)
    {


        if(!$hbg){//feregh
            $hbg = new Hebergement();
        }


        $form = $this->createForm(HebergementType::class,$hbg);


        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid()){


            /** @var UploadedFile $UploadedFile */
            $UploadedFile=$form->get('imagee')->getData();

            if($UploadedFile){
                $destination = $this->getParameter('image_directory');
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

            $this->addFlash(
                'info',
                'Added successfuly' );
            $flashy->success('Hebergement ajouter !', 'http://your-awesome-link.com');


            return $this->redirectToRoute('showback');
        }

        return $this->render('Addhbg.html.twig',[
            'formhbg'=>$form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="del_hbg")
     */
    public function delete($id,Request $request, EntityManagerInterface $manager,FlashyNotifier $flashy)
    {


        $HebergementRepository = $this->getDoctrine()->getRepository(Hebergement::class);

        $hebergement = $HebergementRepository->find($id);
        $manager->remove($hebergement);
        $manager->flush();
        $flashy->success('Hebergement supprimer !', 'http://your-awesome-link.com');
        $this->addFlash(
            'info',
            'Added successfuly' );




        return $this->redirectToRoute('showback', array("actions"=>"delete"));
    }

    /**
     * @Route("/send/{id}", name="send_hbg")
     */
    public function send ($id,\Swift_Mailer $mailer,FlashyNotifier $flashy)
    {
        $donne=$this->getDoctrine()->getRepository(Utilisateur::class)->findAll();
        $hebergement=$this->getDoctrine()->getRepository(Hebergement::class)->findOneby(array('idHbg'=>$id));
        foreach ($donne as $d) {
            $m = (new \Swift_Message('Nouveau Hebergement'))
                // On attribue l'expéditeur
                ->setFrom('wassimgx15@gmail.com')
                // On attribue le destinataire
                ->setTo($d->getEmailuser())
                // On crée le texte avec la vue
                ->setBody(
                    $this->renderView(
                        'emails/hbg.html.twig', compact('hebergement')
                    ),
                    'text/html'
                )
            ;
            try {
                $mailer->send($m);
            } catch (TransportExceptionInterface $e) {
                // some error prevented the email sending; display an
                // error message or try to resend the message
            }
        }

        $flashy->success('email envoyer !', 'http://your-awesome-link.com');
        return $this->redirectToRoute('showback');

    }


    /**
     * @Route("/pdf", name="pdf", methods={"GET"})
     */
    public function pdf(FlashyNotifier $flashy)
    {

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('classic-roman', 'Bold');
        $pdfOptions->setIsRemoteEnabled(true);
        $pdfOptions->setChroot($this->getParameter('kernel.project_dir').'/public/uploads/');


        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $rep = $this->getDoctrine()->getRepository(Hebergement::class);

        $donne=$rep->findAll();

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('mypdf.html.twig', [
            'title' => "List des hebergement",
            'hebergements' =>$donne
        ]);
        $flashy->success('Exported!', 'http://your-awesome-link.com');

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);


    }

    /**
     * @Route("/recherche_hbg", name="ajaxsearch", methods={"GET","POST"})
     */
    public function searchAction(Request $request,PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();

        $requestString = $request->get('q');

        $entities =  $em->getRepository(Hebergement::class)->findEntitiesByString($requestString);

        if(!$entities) {
            $result['Hebergement']['error'] = "No result found :( ";
        } else {
            $result['Hebergement'] = $this->getRealEntities($entities);
        }






        return $this->indexx($request,$paginator,$entities);
        //return new Response(json_encode($entit));
    }

    public function getRealEntities($entities){

        foreach ($entities as $entity){
            $realEntities[$entity->getidHbg()] = [$entity->getPrix(),$entity->getImage(),$entity->getNomHotel(),$entity->getPiscine(),$entity->getAdress()];

        }


        return $realEntities;
    }







    // *********************************MOBILE****************************

    //******************afficher *****************************************/


    /**
     * @Route("/displayhbgM", name="display_hbg")
     */
    public function allhbgAction(SerializerInterface $serializer)
    {
        $hbg= $this->getDoctrine()->getManager()->getRepository(Hebergement::class)->findAll();
        $formatted = $serializer->serialize($hbg,'json',['groups'=>'hebergement']);
        dump($formatted);

        return new JsonResponse($formatted);
    }

    /******************Ajouter *****************************************/
    /**
     * @Route("/addhbgM", name="addhbgM")
     * @Method("POST")
     */

    public function ajouterhbgAction(Request $request,NormalizerInterface $Normalizer)
    {
        $hbg= new Hebergement();
        $hbg->setNom($request->get('nom'));
        $hbg->setCity($request->get('city'));
        // $time = new \DateTime('now');
        //$time->format('Y-m-d');
        //$hbg->setDateAjout(\DateTimeInterface "2000-06-20");
        $hbg->setAdress($request->get('adress'));
        $hbg->setNomHotel($request->get('nomhotel'));
        $hbg->setNbChambres($request->get('nbchambres'));
        $hbg->setNbSuites($request->get('nbsuites'));
        $hbg->setPiscine($request->get('piscine'));
        $hbg->setImage($request->get('image'));
        $hbg->setPrix($request->get('prix'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($hbg);
        $em->flush();
        $jsonContent = $Normalizer->normalize($hbg, 'json',['groups'=>'post:read']);
        return new JsonResponse($jsonContent);




    }

    /**
     * @Route("/Allhbgs", name="Allhbgs")
     */
    public function get_hbgJSON(NormalizerInterface $Normalizer)
    {


        $hbgs=$this->getDoctrine()->getManager()->getRepository(Hebergement::class)->findAll();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($hbgs);
        return new JsonResponse($formatted);



    }

    /**
     * @Route("/deletehbg", name="deletehbg")
     */
    public function delete_hbgJSON(Request $request)

    {$id=$request->get("id");
        $em=$this->getDoctrine()->getManager();
        $hbg=$em->getRepository(Hebergement::class)->find($id);
        if($hbg!=null)
        {$em->remove($hbg);
            $em->flush();
            $serialize=new Serializer([new ObjectNormalizer()]);
            $formatted=$serialize->normalize("hebergement supprimé avec succés");
            return new JsonResponse($formatted);



        }


    }

    /**
     * @Route("/updatehbg{id}", name="updatehbg")
     */
    public function updatehbgAction(Request $request,NormalizerInterface $Normalizer)
    {

        $id=$request->get("id");
        $em=$this->getDoctrine()->getManager();
        $hbg=$em->getRepository(Hebergement::class)->find($id);

        $hbg->setNom($request->get('nom'));
        $hbg->setCity($request->get('city'));
        // $time = new \DateTime('now');
        //$time->format('Y-m-d');
        //$hbg->setDateAjout(\DateTimeInterface "2000-06-20");
        $hbg->setAdress($request->get('adress'));
        $hbg->setNomHotel($request->get('nomhotel'));
        $hbg->setNbChambres($request->get('nbchambres'));
        $hbg->setNbSuites($request->get('nbsuites'));
        $hbg->setPiscine($request->get('piscine'));
        $hbg->setImage($request->get('image'));
        $hbg->setPrix($request->get('prix'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($hbg);
        $em->flush();
        $serialize=new Serializer([new ObjectNormalizer()]);
        $formatted=$serialize->normalize("hebergement modifie avec succés");
        return new JsonResponse($formatted);


    }
}
