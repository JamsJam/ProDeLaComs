<?php

namespace App\Controller\Back\membre;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvitationController extends AbstractController
{
    #[Route('/back/membre/invitation', name: 'app_back_membre_invitation')]
    public function index(): Response
    {
        


        

        return $this->render('Back/membre/invitation/index.html.twig', [
            'controller_name' => 'InvitationController',
        ]);
    }


    
}
