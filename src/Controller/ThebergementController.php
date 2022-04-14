<?php

namespace App\Controller;

use App\Entity\Thebergement;
use App\Form\ThebergementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/thebergement')]
class ThebergementController extends AbstractController
{
    #[Route('/', name: 'app_thebergement_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $thebergements = $entityManager
            ->getRepository(Thebergement::class)
            ->findAll();

        return $this->render('thebergement/index.html.twig', [
            'thebergements' => $thebergements,
        ]);
    }

    #[Route('/new', name: 'app_thebergement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $thebergement = new Thebergement();
        $form = $this->createForm(ThebergementType::class, $thebergement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($thebergement);
            $entityManager->flush();

            return $this->redirectToRoute('app_thebergement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('thebergement/new.html.twig', [
            'thebergement' => $thebergement,
            'form' => $form,
        ]);
    }

    #[Route('/{idHbg}', name: 'app_thebergement_show', methods: ['GET'])]
    public function show(Thebergement $thebergement): Response
    {
        return $this->render('thebergement/show.html.twig', [
            'thebergement' => $thebergement,
        ]);
    }

    #[Route('/{idHbg}/edit', name: 'app_thebergement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Thebergement $thebergement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ThebergementType::class, $thebergement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_thebergement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('thebergement/edit.html.twig', [
            'thebergement' => $thebergement,
            'form' => $form,
        ]);
    }

    #[Route('/{idHbg}', name: 'app_thebergement_delete', methods: ['POST'])]
    public function delete(Request $request, Thebergement $thebergement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$thebergement->getIdHbg(), $request->request->get('_token'))) {
            $entityManager->remove($thebergement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_thebergement_index', [], Response::HTTP_SEE_OTHER);
    }
}
