<?php

namespace App\Controller;

use App\Entity\Room;
use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Requirement\Requirement;

class ReservationController extends AbstractController
{
    #[Route('/account', name: 'account')]
    public function index(ReservationRepository $reservationRepository): Response
    {
        // Vérifie si l'utilisateur est connecté, sinon redirige vers la page de connexion
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        
        // Récupère toutes les réservations de l'utilisateur connecté depuis le repository
        // $user = $this->getUser();
        $reservations = $reservationRepository->findBy(['user' => $this->getUser()]);

        return $this->render('page/account.html.twig', [
            'reservations' => $reservations
        ]);
    }

    #[Route('/book-a-room/{id}', name: 'booking', methods: ['GET', 'POST'])]
    public function bookRoom(int $id, Request $request, EntityManagerInterface $em)
    {
        // Vérifie si l'utilisateur est connecté, sinon redirection vers la page de connexion
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
    
        // Récupère la salle à partir de l'ID fourni dans l'URL
        $room = $em->getRepository(Room::class)->find($id);
    
        // Vérifie si la salle existe
        if (!$room) {
            throw $this->createNotFoundException('Room not found');
        }
    
        // Crée une nouvelle instance de Reservation
        $reservation = new Reservation();
        $reservation->setRoom($room);
        $reservation->setUser($this->getUser());
    
        // Crée le formulaire de réservation
        $form = $this->createForm(ReservationType::class, $reservation);
    
        // Gère la soumission du formulaire
        $form->handleRequest($request);
    
        // Vérifie si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Persiste la nouvelle réservation dans la base de données
            $em->persist($reservation);
            $em->flush();
    
            // Message flash pour indiquer que la réservation a été effectuée avec succès
            $this->addFlash('success', 'Room booked successfully.');
    
            // Redirige vers la page des réservations de l'utilisateur
            return $this->redirectToRoute('app_room');
        }
    
        // Affiche le formulaire de réservation dans le modèle Twig
        return $this->render('reservation/book_room.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/reservation/{id}', name: 'reservation_show', methods: ['GET'])]
    public function show(int $id, ReservationRepository $reservationRepository): Response
    {
        // Vérifie si l'utilisateur est connecté, sinon redirige vers la page de connexion
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        // Récupère la réservation à partir de l'ID fourni dans l'URL
        $reservation = $reservationRepository->find($id);

        // Vérifie si la réservation existe
        if (!$reservation) {
            throw $this->createNotFoundException('Reservation not found');
        }

        // Affiche les détails de la réservation
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS])]
    public function edit(Reservation $reservation, Request $request, EntityManagerInterface $em) {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush(); //pr sauvegarder les changes à la bd
            $this->addFlash('success', 'la réservation a été modifiée');
            return $this->redirectToRoute('reservations');
        }
        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS])]
    public function remove(Reservation $reservation, EntityManagerInterface $em)
    {
        $em->remove($reservation);
        $em->flush();
        $this->addFlash(
           'success',
           'La réservation a été annulée'
        );
        return $this->redirectToRoute('account');
    }


}
