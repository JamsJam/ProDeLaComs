<?php

namespace App\Controller\Back\membre;

use App\Entity\Option;
use App\Form\OptionType;
use App\Repository\OptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/back/membre/option')]
class OptionController extends AbstractController
{
    #[Route('/', name: 'app_back_membre_option_index', methods: ['GET'])]
    public function index(OptionRepository $optionRepository): Response
    {
        return $this->render('back/membre/option/index.html.twig', [
            'options' => $optionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_back_membre_option_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OptionRepository $optionRepository): Response
    {
        $option = new Option();
        $form = $this->createForm(OptionType::class, $option);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $optionRepository->save($option, true);

            return $this->redirectToRoute('app_back_membre_option_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/membre/option/new.html.twig', [
            'option' => $option,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_membre_option_show', methods: ['GET'])]
    public function show(Option $option): Response
    {
        return $this->render('back/membre/option/show.html.twig', [
            'option' => $option,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_back_membre_option_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Option $option, OptionRepository $optionRepository): Response
    {
        $form = $this->createForm(OptionType::class, $option);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $optionRepository->save($option, true);

            return $this->redirectToRoute('app_back_membre_option_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/membre/option/edit.html.twig', [
            'option' => $option,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_membre_option_delete', methods: ['POST'])]
    public function delete(Request $request, Option $option, OptionRepository $optionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$option->getId(), $request->request->get('_token'))) {
            $optionRepository->remove($option, true);
        }

        return $this->redirectToRoute('app_back_membre_option_index', [], Response::HTTP_SEE_OTHER);
    }
}
