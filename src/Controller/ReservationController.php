<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Utilisateurs;
use App\Entity\Thebergement;
use App\Entity\Paiement;
use App\Entity\Ticket;
use App\Repository\TicketRepository;
use App\Repository\ReservationRepository;
use App\Form\ReservationType;
use App\Form\ReservationEditing;
use App\Form\ReservationValidating;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\Component\Mime\Email;
use Dompdf\Dompdf;
use Dompdf\Options;

#[Route('/reservation')]
class ReservationController extends AbstractController
{
    #[Route('/{etat}', name: 'app_reservation_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, ReservationRepository $reservationRepository, $etat): Response
    {
        $hebergement = new Thebergement();
        $hebergement->setNomHotel("El mouradi");
        $utilisateur = new Utilisateurs();
        $utilisateur->setRole("Admin");
        $utilisateur->setIdUser(22);
        if ($utilisateur->getRole() == "Client"){ 
            $reservations = $entityManager
            ->getRepository(Reservation::class)
            ->findUserReservations(22);
            //dd($utilisateur->getIdUser());
            ///dd($utilisateur);
            return $this->render('reservation/indexClient.html.twig', [
                'reservations' => $reservations,
            ]);
        }else{
            switch($etat){
                case '-1': 
                    $reservations = $entityManager
                    ->getRepository(Reservation::class)
                    ->findCanceled();
                    break;
                case '0':
                    $reservations = $entityManager
                    ->getRepository(Reservation::class)
                    ->findAwaiting();
                    break;
                case '1':
                    $reservations = $entityManager
                    ->getRepository(Reservation::class)
                    ->findValidated();
                    break;
                case '99':
                    $reservations = $entityManager
                    ->getRepository(Reservation::class)
                    ->findArchive();
                    break;
                default :
                    $reservations = $entityManager
                    ->getRepository(Reservation::class)
                    ->findAll();
                    break;
            }
                    
                    return $this->render('reservation/index.html.twig', [
                        'reservations' => $reservations,
                        'utilisateur' => $utilisateur,
                        'hebergement' => $hebergement,
                    ]);
            //dd($utilisateur);
        }
            //->findUserReservations(22);
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        $userID = 22;
        $utilisateur = $entityManager
            ->getRepository(Utilisateurs::class)
            ->findUser($userID);
        //dd($utilisateur);
        //$user->setIduser(22);
        $reservation->setIduser($utilisateur);
        $reservation->setValide(0);
        $reservation->setDateres(new \DateTime('now'));
        $reservation->setDeadlineannulation($reservation->getDateres()->modify("+1 day"));
        //dd($reservation->getDeadlineannulation());
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();
            $idRes = $reservation->getIdRes();
            return $this->redirectToRoute('app_paiement_new', [
                'idRes' => $idRes
            ], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/stat/a', name:'app_reservation_stat')]
    public function stat(ChartBuilderInterface $chartBuilder, EntityManagerInterface $entityManager): Response
    {
        $i=0;
        $labels=['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'];
        foreach($labels as $l){
            //dd($i);
            $data[$i]=$entityManager
                ->getRepository(Reservation::class)
                ->getReservationsCount($i);
                $i=$i+1;
        }
        //dd($data);
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Monthly Reservations Count',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $data,
                ],
            ],
        ]);

       // dd($chart);
        return $this->render('reservation/stat.html.twig', [
            
            'monthlychart' => $chart,
        ]);
    }


    #[Route('/print', name:'print')]
    public function print(): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);
        $pdfOptions->set('isHtml5ParserEnabled', true);
        $pdfOptions->set('isRemoteEnabled', TRUE);
    }

    #[Route('/{idres}/smail', name: 'app_reservation_smail', methods: ['GET'])]
    public function sendMail(MailerInterface $mailer, EntityManagerInterface $em, $idres): Response
    {
        /*$paiement = $em
            ->getRepository(Paiement::class)
            ->findPaiement($idres);
        $ticket = $em
            ->getRepository(Ticket::class)
            ->findTicket($idres,$paiement->getIdpmt());*/
        $FILENAME="ticket".(string)$idres;
        $PathForMail="C:/Users/Houssem/Downloads/".$FILENAME.(string)".pdf";
        //dd($PathForMail);
        $email = (new Email())
        ->from('hawesesprit22@gmail.com')
        ->to('houssem.hosni@esprit.tn')
        //->cc('cc@example.com')
        //->bcc('bcc@example.com')
        //->replyTo('fabien@example.com')
        //->priority(Email::PRIORITY_HIGH)
        ->subject('Confirmation du réservation!')
        ->text('Automatische Emailsender!')
        ->attachFromPath($PathForMail, 'Ticket Réservation')
        ->html('<p>Vous trouverez ci-joint votre VOUCHER!</p>');
        //dd($email);
        try {
            $mailer->send($email);
            //dd($mailer);
        } catch (TransportExceptionInterface $e) {
            // some error prevented the email sending; display an
            // error message or try to resend the message
            dd($e);
        }

        return $this->redirectToRoute('app_reservation_index', [ 'etat' => 0], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{idres}/validate', name: 'app_reservation_validate', methods: ['GET','POST'])]
    public function validate(Request $request, Reservation $reservation, EntityManagerInterface $entityManager,MailerInterface $mailer, $idres): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);
        $pdfOptions->set('isHtml5ParserEnabled', true);
        $pdfOptions->set('isRemoteEnabled', TRUE);
        $hebergement = new Thebergement();
        $hebergement->setNomHotel("El mouradi");
            $dompdf = new Dompdf($pdfOptions);
            $reservation = $entityManager
                ->getRepository(Reservation::class)
                ->findReservation($idres);
            $utilisateur = $entityManager
                ->getRepository(Utilisateurs::class)
                ->findUser($reservation->getIduser());
            $paiement = $entityManager
                ->getRepository(Paiement::class)
                ->findPaiement($reservation->getIdres());

                $html = $this->renderView('reservation/validate.html.twig', [
                    'reservation' => $reservation,
                    'paiement' => $paiement,
                    'hebergement' => $hebergement,
                    'utilisateur' => $utilisateur,
                    'valid' => 0,
                  //  'form' => $form,
                ]);

            $reservation->setValide(1);
            $entityManager->flush();
            //dd($html);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4','landscape');
            $dompdf->render();
            //dd($dompdf);
            $FILENAME="ticket".(string)$reservation->getIdres();
            //dd($FILENAME);
            $dompdf->stream($FILENAME,[
                "Attachement" => true
            ]);
            
            //sendMail($mailer,$PathForMail);

           /* $user = new User () ;
            $message = (new \Swift_Message('Hello')) ;
            //ajouter une image dans le mail
            //$img =
           // $message->embed(\Swift_Image::fromPath('img/logo.png'));
            $message->setFrom("hawesesprit22@esprit.tn")
            ->setTo("houssem.hosni@esprit.tn")
            //message simple
            ->setBody(" your message","text/html") ;
           /* ->setBody( $this->renderView(
                "emails/registration.html.twig",
                [
                'name' => $user->getUsername(), 'picture' => $img]),
                'text/html'
                );*/
                //$mailer->send($message);
                

        //return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        //}        
        //dd($html);
        return $this->redirectToRoute('app_reservation_index', [ 'etat' => 0 ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{idres}/cancel', name: 'app_reservation_cancel', methods: ['GET'])]
    public function cancel(Request $request, Reservation $reservation, EntityManagerInterface $entityManager, $idres): Response
    {
            $reservation->setValide(-1);
            $paiement = $entityManager
                ->getRepository(Paiement::class)
                ->findPaiement($reservation->getIdres());
            $paiement->setCanceled(1);
            //dd($paiement);
            $ticket = $entityManager
                ->getRepository(Ticket::class)
                ->findTicket($reservation->getIdres(),$paiement->getIdpmt());
            $ticket->setDeleted(1);
            //dd($ticket);
            $entityManager->flush();

            //dd($PathForMail);
            $email = (new Email())
            ->from('hawesesprit22@gmail.com')
            ->to('houssem.hosni@esprit.tn')
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Annulation du réservation!')
            ->text('Automatische Emailsender!')
            ->html('<p>votre Réservation a été annulée!</p>');
            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                dd($e);
            }
            
        return $this->redirectToRoute('app_reservation_index', [ 'etat' => 0 ], Response::HTTP_SEE_OTHER);
    }
    
    #[Route('/{idres}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{idres}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        //dd($reservation);
        $form = $this->createForm(ReservationEditing::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_reservation_index', [ 'etat' => 0 ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{idres}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getIdres(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [ 'etat' => 0 ], Response::HTTP_SEE_OTHER);
    }
}
