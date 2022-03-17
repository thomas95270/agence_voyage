<?php

namespace App\Controller\Back;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ParticipantRepository;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/reservation')]
class ReservationController extends AbstractController
{
    #[Route('/', name: 'app_reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('back/reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReservationRepository $reservationRepository): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $date_reservation = new \DateTime();
            $reservation->setDateReservation($date_reservation);
            
            $reservation->setStatut('En Attente');

            $participants = $form->getData()->getParticipants();
            foreach ($participants as $participant) {
                $participant->setReservation($reservation);
                $reservation->addParticipant($participant);
                
            }
            $reservationRepository->add($reservation);
            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        return $this->render('back/reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, ParticipantRepository $participantRepository, ReservationRepository $reservationRepository): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $date_reservation = new \DateTime();
            $reservation->setDateReservation($date_reservation);

            $participants = $form->getData()->getParticipants();

            foreach ($participants as $participant) {
                $participantRepository->add($participant);
            }
            foreach ($participants as $participant) {
                $participant->setReservation($reservation);
                $reservation->addParticipant($participant);
            }
            $reservationRepository->add($reservation);
            
            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, ReservationRepository $reservationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $reservationRepository->remove($reservation);
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}
