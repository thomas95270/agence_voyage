<?php

namespace App\Controller\Back;

use App\Entity\Destination;
use App\Form\DestinationType;
use App\Repository\DestinationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/destination')]
class DestinationController extends AbstractController
{
    #[Route('/', name: 'app_destination_index', methods: ['GET'])]
    public function index(DestinationRepository $destinationRepository): Response
    {
        return $this->render('back/destination/index.html.twig', [
            'destinations' => $destinationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_destination_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DestinationRepository $destinationRepository): Response
    {
        $destination = new Destination();
        $form = $this->createForm(DestinationType::class, $destination);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $destinationRepository->add($destination);
            return $this->redirectToRoute('app_destination_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/destination/new.html.twig', [
            'destination' => $destination,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_destination_show', methods: ['GET'])]
    public function show(Destination $destination): Response
    {
        return $this->render('back/destination/show.html.twig', [
            'destination' => $destination,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_destination_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Destination $destination, DestinationRepository $destinationRepository): Response
    {
        $form = $this->createForm(DestinationType::class, $destination);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $destinationRepository->add($destination);
            return $this->redirectToRoute('app_destination_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/destination/edit.html.twig', [
            'destination' => $destination,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_destination_delete', methods: ['POST'])]
    public function delete(Request $request, Destination $destination, DestinationRepository $destinationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$destination->getId(), $request->request->get('_token'))) {
            $destinationRepository->remove($destination);
        }

        return $this->redirectToRoute('app_destination_index', [], Response::HTTP_SEE_OTHER);
    }
}
