<?php

namespace App\Controller;

use App\Entity\Hebergement;
use App\Repository\HebergementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatisticController extends AbstractController
{
    /**
     * @Route("/statistic", name="app_statistic")
     */
    public function index(): Response
    {
        return $this->render('statistic/stats.html.twig', [
            'controller_name' => 'StatisticController',
        ]);
    }


   /**
    * @Route("/stats", name="rec_stat")
    */
    public function statistiques (HebergementRepository $rep){

        //chercher les types de reclamation

        $hbgs = $rep->countByNb();

        $recType = [];
        $recCount = [];


        foreach($hbgs as $hbg){

            //$recType[] = $reclamation->getType();
            $recType[] = $hbg ['nom'];
            $recCount[]= $hbg ['nb'];
            //$recCount[] = count($recType);
        }
        return $this->render('statistic/stats.html.twig', [
            'recType' => json_encode($recType),
            'recCount' => json_encode($recCount),


        ]);

        
    }
}