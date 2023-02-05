<?php

namespace App\Controller\Back\membre;

use App\Entity\Membre;
use App\Form\MembreType;
use App\Repository\MembreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('')]
class MembreController extends AbstractController
{
    /**
     * Page d'accueil du crud Membre
     */
    #[Route('/accueil/', name: 'app_accueil', methods: ['GET'])]
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
}
