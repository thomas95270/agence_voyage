<?php

namespace App\Controller\Front;

use App\Entity\Client;
use App\Entity\Produit;
use App\Form\ClientType;
use App\Form\ContactType;
use App\Entity\Destination;
use App\Entity\Reservation;
use App\Form\ReservationFrontType;
use App\Repository\ProduitRepository;
use App\Repository\ConseillerRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DestinationRepository;
use App\Repository\ParticipantRepository;
use App\Repository\ReservationRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class FrontController extends AbstractController
{

/* *************************************** ACCUEIL *****************************************************************/

#[Route('/', name: 'accueil')]
public function index(ConseillerRepository $conseillerRepository): Response
{
    
    $conseillers = $conseillerRepository->findReferents();
    return $this->render('front/index.html.twig', [
        'conseillers' => $conseillers,
    ]);
}

/* *************************************** INSCRIPTION *****************************************************************/
    #[Route('/inscription', name: 'client_inscription', methods: ['GET', 'POST'])]
    public function inscriptionClient(Request $request, UserPasswordHasherInterface $encoder, EntityManagerInterface $manager): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $encoder->hashPassword($client, $client->getPassword() );
            $client->setPassword($password);

            $manager->persist($client);
            $manager->flush();

            return $this->redirectToRoute('accueil');
        }

        return $this->renderForm('front/client_inscription.html.twig', [
            'form' => $form,
        ]);
    }

/* *************************************** Produit Selectionné *****************************************************************/

    #[Route('/{id}/produit', name: 'front_produit', methods: ['GET', 'POST'])]
    public function frontProduit(Produit $produit, ProduitRepository $produitRepository, DestinationRepository $destinationRepository): Response
    {
        $prods=[];
        $destinations = $produit->getDestinations();
        foreach ($destinations as $destination) {
            // Ici tu veux récupérer les produits
            // Créer une requête dans ProduitRepository pour récupérer les produits par Destination
            // findBy($destination)
           // $prod = $destination->getProduits();
           $prods += $produitRepository->findProduitsByDestination($destination);
            // dd($prod);
            // array_push($prods, $produitRepository->findProduitsByDestination($destination));
        }

        return $this->render('front/produit.html.twig', [
            'produit' => $produit,
            'prods' => $prods,

        ]);
    }

/* *************************************** Destination Selectionnée *****************************************************************/

    #[Route('/{id}/destination', name: 'front_destination', methods: ['GET', 'POST'])]
    public function frontDestination(Destination $destination): Response
    {
        $produits = $destination->getProduits();
        return $this->render('front/destination.html.twig', [
            'destination' => $destination,
            'produits' => $produits
        ]);
    }

/* *************************************** Réserver en ligne *****************************************************************/

    #[Route('/reservation', name: 'front_reservation', methods: ['GET', 'POST'])]
    public function reservationClient(Request $request, ParticipantRepository $participantRepository, ReservationRepository $reservationRepository): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationFrontType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $date_reservation = new \DateTime();
            $reservation->setDateReservation($date_reservation);
            $reservation->setStatut('En Attente');

            $participants = $form->getData()->getParticipants();
            
            foreach ($participants as $participant) {
                $participantRepository->add($participant);
                $participant->setReservation($reservation);
                $reservation->addParticipant($participant);

            $reservationRepository->add($reservation);
            return $this->redirectToRoute('accueil', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('front/reservation.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }
/* *************************************** Profil *****************************************************************/

#[Route('/profil', name: 'profil', methods: ['GET', 'POST'])]
public function profil(): Response
{
    $user = $this->getUser();
    return $this->render('front/profil.html.twig', [
        'user' => $user
    ]);
}

/* *************************************** CONTACT *****************************************************************/

#[Route('/contact', name: 'contact', methods: ['GET', 'POST'])]
public function contact(Request $request, MailerInterface $mailer): Response
{

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            $data = $form->getData();

            $email = new TemplatedEmail();
            $email
                ->from($data['email'])
                ->to('thomas.vmaagdenberg@gmail.com')
                ->subject('Nouveau message de Blog')
                ->htmlTemplate('front/email.html.twig')
                ->context([
                    'data' =>$data  
                ])
            ;

            $mailer->send($email);
        }


    return $this->renderForm('front/contact.html.twig', [
        'form' => $form,
    ]);
}

}