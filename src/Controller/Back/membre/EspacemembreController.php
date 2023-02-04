<?php

namespace App\Controller\Back\membre;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspacemembreController extends AbstractController
{
    #[Route('/back/membre/espacemembre', name: 'app_back_membre_espacemembre')]
    public function index(): Response
    {
        return $this->render('Back/membre/espacemembre/index.html.twig', [
            'controller_name' => 'EspacemembreController',
        ]);
    }
}
