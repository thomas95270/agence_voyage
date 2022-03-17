<?php

namespace App\Controller\Back;

use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(ReservationRepository $reservationRepository): Response
    {
        $statut='En Attente';
        $reservations = $reservationRepository->findByStatut($statut);
        return $this->render('back/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }
}
