<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\Utilisateurs;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use \Twilio\Rest\Client;


/**
 * @Route("/reclamation")
 */
class ReclamationController extends AbstractController
{
    private $twilio;

    /**
     * @Route("/", name="app_reclamation_index", methods={"GET"})
     */
    public function index(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/my", name="my", methods={"GET"})
     */
    public function myIndex(ReclamationRepository $reclamationRepository): Response
    {
        $currentUser = $this->getDoctrine()->getRepository(Utilisateurs::class)->find(21);
        return $this->render('reclamation/indexMy.html.twig', [
            'reclamations' => $reclamationRepository->findBy(['iduser' => $currentUser]),
        ]);
    }

    /**
     * @Route("/new", name="app_reclamation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ReclamationRepository $reclamationRepository): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $currentUser = $this->getDoctrine()->getRepository(Utilisateurs::class)->find(21);
            $reclamation->setIduser($currentUser);
            $reclamation->setDateajoutrec(new \DateTime());
            $reclamation->setDatetraitrec(NULL);
            $reclamationRepository->add($reclamation);

            $accountSid = $_ENV['TWILIO_AUTH_SID'];
            $authToken = $_ENV['TWILIO_AUTH_TOKEN'];
            $twilioNumber = $_ENV['TWILIO_PHONE_NUMBER'];

            $twilio = new Client($accountSid, $authToken);
            $message = $twilio->messages->create('+21650903305',array(
                'from' => '+19402918233', // My Twilio phone number
                'body' => 'une nouvelle reclamation a été ajouté'
            ));


            return $this->redirectToRoute('my', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_reclamation_show", methods={"GET"})
     */
    public function show(Reclamation $reclamation): Response
    {
       
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_reclamation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->add($reclamation);
            return $this->redirectToRoute('my', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_reclamation_delete", methods={"POST"})
     */
    public function delete(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getIdRec(), $request->request->get('_token'))) {
            $reclamationRepository->remove($reclamation);
        }

        return $this->redirectToRoute('my', [], Response::HTTP_SEE_OTHER);
    }
    
    /**
     * @Route("/{id}/admin", name="delete_admin", methods={"POST"})
     */
    public function deleteAdmin(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getIdRec(), $request->request->get('_token'))) {
            $reclamationRepository->remove($reclamation);
        }

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/traiter", name="traiter_reclamation", methods={"GET", "POST"})
     */
    public function traite(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository, MailerInterface $mailer): Response
    {
        $user = $reclamation->getIduser();
        $email = (new Email())
            ->from('hawes@adm.in')
            ->to($user->getEmailuser())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Reclamation traité!')
            ->text('Hi '.$user->getNomuser().' '.$user->getPrenomuser().', Votre reclamation a ete traite, Merci')
            ->html('<p>Hi '.$user->getNomuser().' '.$user->getPrenomuser().',</p> <br> <p>Votre reclamation a ete traite,</p> <br> <p>Merci</p> ');
        $mailer->send($email);


        $reclamation->setTraite(1);
        $reclamation->setDatetraitrec(new \DateTime());


        $reclamationRepository->add($reclamation);

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);

    }

    /**
     * @Route("/rec56a6s1d2/rec56a6s1d2", name="rec_serach", methods={"GET"})
     */
    public function search(Request $request,ReclamationRepository $reclamationRepository): Response
    {

        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamationRepository->findInput($request->get("value")),
        ]);
    }
}
