<?php

namespace App\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    
    #[Route('/', name: 'app_front_home')]
    public function index(): Response
    {

        return $this->render('front/home/index.html.twig', [
            
        ]);
    }

    /**
     * Function menant a l'index du crud Membre
     */
    #[Route('/accueil', name: 'app_front_accueil')]
    public function accueil(): Response
    {

        return $this->render('front/home/index.html.twig', [
            
        ]);
    }
}
