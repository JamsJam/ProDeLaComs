<?php

namespace App\Controller\Back\membre;

use App\Entity\Membre;
use App\Form\MembreType;
use App\Repository\MembreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Node\IfNode;

#[Route('')]
class MembreController extends AbstractController
{
    
    #[Route('/accueil/', name: 'app_accueil', methods: ['GET', 'POST'])]
    public function index(MembreRepository $membreRepository): Response
    {

        

        return $this->render('back/membre/membre/index.html.twig', [
            'membres' => $membreRepository->findAll(),
        ]);
    }

    #[Route('/back/membre/membre/new', name: 'app_back_membre_membre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MembreRepository $membreRepository): Response
    {
        $membre = new Membre();
        $form = $this->createForm(MembreType::class, $membre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $membreRepository->save($membre, true);

            return $this->redirectToRoute('app_back_membre_membre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/membre/membre/new.html.twig', [
            'membre' => $membre,
            'form' => $form,
        ]);
    }

    #[Route('/back/membre/membre/{id}', name: 'app_back_membre_membre_show', methods: ['GET'])]
    public function show(Membre $membre): Response
    {
        return $this->render('back/membre/membre/show.html.twig', [
            'membre' => $membre,
        ]);
    }

    #[Route('/back/membre/membre/{id}/edit', name: 'app_back_membre_membre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Membre $membre, MembreRepository $membreRepository): Response
    {
        $form = $this->createForm(MembreType::class, $membre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $membreRepository->save($membre, true);

            return $this->redirectToRoute('app_back_membre_membre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/membre/membre/edit.html.twig', [
            'membre' => $membre,
            'form' => $form,
        ]);
    }

    #[Route('/back/membre/membre/{id}', name: 'app_back_membre_membre_delete', methods: ['POST'])]
    
    public function delete(Request $request, Membre $membre, MembreRepository $membreRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$membre->getId(), $request->request->get('_token'))) {
            $membreRepository->remove($membre, true);
        }

        return $this->redirectToRoute('app_back_membre_membre_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * return some user id accordinatly the search in app_accueil. for ajax request only or return a HTTP 403
     */
    #[Route('/api/fetchUser', name: 'api_fetch_user', methods: ['GET','POST'])]
    public function fetchUserId(Request $request, MembreRepository $mp)
    {
        //? donnée d'entrée
            $query = $request->request->all();
            $submittedToken = $query['_token'];
            $ids = [];
            
        //? if  request not is an AJAX request or token invalid
            if (! $request->isXmlHttpRequest() || ! $this->isCsrfTokenValid('fetchUser', $submittedToken)) {

                return new Response(null, 403);
            }
        
        //? traitement de la requete
        
            $searchValue = $query['search'];


            !$searchValue ? $result = [] : $result = $mp->rechercheMembre($searchValue);
            
            

            //? si aucun resultats
                if( $result == []){

                    $message = "Aucun resultat corerspondant a votre recherche";

                }
                else{

                    foreach ($result as $id) {
                        array_push($ids, $id['id']);
                    }
                    $message = '';

                }

        
        return new JsonResponse([
            'message' => $message,
            'data' => $ids,
            
        ]);
    }

}
