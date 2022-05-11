<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Utilisateurs;
use App\Form\AvisType;
use App\Repository\AvisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/avis")
 */
class AvisController extends AbstractController
{
    /**
     * @Route("/", name="app_avis_index", methods={"GET"})
     */
    public function index(AvisRepository $avisRepository): Response
    {
        return $this->render('avis/index.html.twig', [
            'avis' => $avisRepository->findAll(),
            'rating' => $avisRepository->avgRating(),
        ]);
    }

    /**
     * @Route("/my", name="myAvis", methods={"GET"})
     */
    public function myAvis(AvisRepository $avisRepository): Response
    {
        return $this->render('avis/indexMy.html.twig', [
            'avis' => $avisRepository->findBy(['iduser' => 21]),
        ]);
    }

    /**
     * @Route("/new", name="app_avis_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AvisRepository $avisRepository): Response
    {
        $avi = new Avis();
        $form = $this->createForm(AvisType::class, $avi);
        $form->handleRequest($request);

        if ($request->request->get('stars') && $avi->getDescAvis()) {
            $currentUser = $this->getDoctrine()->getRepository(Utilisateurs::class)->find(21);
            $avi->setIduser($currentUser);

            $avi->setEtoile($request->request->get('stars'));
            $avi->setDateajoutavis(new \DateTime());

            $avisRepository->add($avi);
            return $this->redirectToRoute('myAvis', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('avis/new.html.twig', [
            'avi' => $avi,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_avis_show", methods={"GET"})
     */
    public function show(Avis $avi): Response
    {
        return $this->render('avis/show.html.twig', [
            'avi' => $avi,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_avis_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Avis $avi, AvisRepository $avisRepository): Response
    {
        $form = $this->createForm(AvisType::class, $avi);
        $form->handleRequest($request);

            if ($request->request->get('stars')) {
                $avi->setEtoile($request->request->get('stars'));

                $avisRepository->add($avi);
                return $this->redirectToRoute('myAvis', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('avis/edit.html.twig', [
            'avi' => $avi,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_avis_delete", methods={"POST"})
     */
    public function delete(Request $request, Avis $avi, AvisRepository $avisRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$avi->getIdAvis(), $request->request->get('_token'))) {
            $avisRepository->remove($avi);
        }

        return $this->redirectToRoute('myAvis', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/aa", name="app_avis_delete_aa", methods={"POST"})
     */
    public function deleteaa(Request $request, Avis $avi, AvisRepository $avisRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$avi->getIdAvis(), $request->request->get('_token'))) {
            $avisRepository->remove($avi);
        }

        return $this->redirectToRoute('app_avis_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/avi56a6s1d2/avi56a6s1d2", name="avi_serach", methods={"GET"})
     */
    public function search(Request $request,AvisRepository $avisRepository): Response
    {
        return $this->render('avis/index.html.twig', [
            'avis' => $avisRepository->findInput($request->get("value")),
            'rating' => $avisRepository->avgRating(),

        ]);
    }
}
