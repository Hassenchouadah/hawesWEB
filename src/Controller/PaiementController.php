<?php

namespace App\Controller;

use App\Entity\Paiement;
use App\Entity\Utilisateurs;
use App\Entity\Reservation;
use App\Repository\PaiementRepository;
use App\Repository\ReservationRepository;
use App\Form\PaiementType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityRepository;

#[Route('/paiement')]
class PaiementController extends AbstractController
{
    #[Route('/', name: 'app_paiement_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $utilisateur = new Utilisateurs();
        $utilisateur->setRole("Admin");
        $utilisateur->setIdUser(22);
        if ($utilisateur->getRole() == "Client"){ 
            $reservations = $entityManager
                ->getRepository(Reservation::class)
                ->findUserReservations($utilisateur->getIduser());
            //dd($reservations);
            $paiements[] = new Paiement();
            $i=0;
            foreach($reservations as $r){
                $paiement = $entityManager
                    ->getRepository(Paiement::class)
                    ->findPaiement($r->getIdres());
                    $paiements[$i]=$paiement;
                    $i=$i+1;
            }
        return $this->render('paiement/indexClient.html.twig', [
            'paiements' => $paiements,
        ]);
        }else{
            $paiements = $entityManager
            ->getRepository(Paiement::class)
            ->findAll();
            return $this->render('paiement/index.html.twig', [
                'paiements' => $paiements,
            ]);
            //dd($utilisateur);
        }
    }

    #[Route('/new/{idRes}', name: 'app_paiement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,int $idRes,ReservationRepository $reservationRepository): Response
    {   
        
        $paiement = new Paiement();
        
      
        $form = $this->createForm(PaiementType::class, $paiement);
        $form->handleRequest($request);
        $paiement->setDatepmt(new \DateTime('now'));
        $paiement->setCanceled(0);
        //
        if (    $form->isSubmitted() && $form->isValid()    ) {  
            //$reservation = $this->getDoctrine()->getRepository(Reservation::class)->find($idRes);
            //$paiement->setIdRes($reservation);  
            $paiement->setIdRes($reservationRepository->find($idRes)); 
                
            $entityManager->persist($paiement);
         
            $entityManager->flush();
            return $this->redirectToRoute('app_ticket_new', [
                'idres'=>$idRes,
                'idpmt'=>$paiement->getIdpmt()
            ], Response::HTTP_SEE_OTHER);
        }
        //dd($paiement);
        return $this->renderForm('paiement/new.html.twig', [
            'paiement' => $paiement,
            'idRes'=>$idRes,
            'form' => $form,
        ]);
    }

    #[Route('/{idpmt}', name: 'app_paiement_show', methods: ['GET'])]
    public function show(Paiement $paiement): Response
    {
        return $this->render('paiement/show.html.twig', [
            'paiement' => $paiement,
        ]);
    }

    #[Route('/{idpmt}/edit', name: 'app_paiement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Paiement $paiement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PaiementType::class, $paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_paiement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('paiement/edit.html.twig', [
            'paiement' => $paiement,
            'form' => $form,
        ]);
    }

    #[Route('/{idpmt}/cancel', name: 'app_paiement_delete', methods: ['GET'])]
    public function delete(Request $request, Paiement $paiement, EntityManagerInterface $entityManager): Response
    {
        $paiement->setCanceled(1);
        $entityManager->flush();
        return $this->redirectToRoute('app_paiement_index', [], Response::HTTP_SEE_OTHER);
    }
}
