<?php

namespace App\Controller;

use App\Entity\Room;
use App\Repository\RoomRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/r')]
class RoomController extends AbstractController
{
    #[Route('/', name: 'app_room', methods: ['GET'])]
    public function index(
        RoomRepository $roomRepository,
        PaginatorInterface $paginator,
        Request $request,
    ): Response {
        $pagination = $paginator->paginate(
            $roomRepository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            8 /*limit per page*/
        );

        return $this->render('room/index.html.twig', [
            'rooms' => $pagination,
        ]);
    }

    #[Route('/{category}', name: 'app_room_category', methods: ['GET'])]
    public function category(
        RoomRepository $roomRepository,
        PaginatorInterface $paginator,
        string $category,
        Request $request,
    ): Response {

        $pagination = $paginator->paginate(
            $roomRepository->findBy(['category' => $category]),
            $request->query->getInt('page', 1),
            8
        );

        return $this->render('room/category.html.twig', [
            'rooms' => $pagination,
            'catRooms' => $roomRepository->findBy(
                ['category' => $category]
            )
        ]);
    }

    #[Route('/show/{id}', name: 'room.show', requirements: ['id' => '\d+'])]
    public function show(int $id, RoomRepository $roomRepository): Response
    {
        // Vérifie si l'utilisateur est connecté, sinon redirige vers la page de connexion
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        // Récupère la salle à partir de l'ID fourni dans l'URL
        $room = $roomRepository->find($id);

        // Vérifie si la salle existe
        if (!$room) {
            throw $this->createNotFoundException('Aucune salle trouvée');
        }

        // Affiche les détails de la salle
        return $this->render('room/show.html.twig', [
            'room' => $room,
        ]);
    }
}
