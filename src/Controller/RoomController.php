<?php

namespace App\Controller;

use App\Repository\RoomRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/r')] 
class RoomController extends AbstractController
{
    #[Route('/', name: 'app_room', methods: ['GET'])]
    public function index(
        RoomRepository $roomRepository,
    ): Response

    {
        return $this->render('room/index.html.twig', [
            'rooms' => $roomRepository->findAll()
        ]);
    }
}
