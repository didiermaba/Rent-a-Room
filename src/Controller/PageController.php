<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('page/home.html.twig', [
        ]);
    }

    #[Route('/reunion', name: 'reunion', methods: ['GET'])]
    public function reunion(): Response
    {
        return $this->render('page/home.html.twig', [
            'title' => 'Salles de réunion',
        ]);
    }

    #[Route('/formation', name: 'formation', methods: ['GET'])]
    public function formation(): Response
    {
        return $this->render('page/home.html.twig', [
            'title' => 'Salles de formation',
        ]);
    }

    #[Route('/amphitheatre', name: 'amphitheatre', methods: ['GET'])]
    public function amphitheatre(): Response
    {
        return $this->render('page/home.html.twig', [
            'title' => 'Amphithéatre',
        ]);
    }

    #[Route('/spectacle', name: 'spectacle', methods: ['GET'])]
    public function spectacle(): Response
    {
        return $this->render('page/home.html.twig', [
            'title' => 'Salles de spectacle',
        ]);
    }

    #[Route('/polyvalente', name: 'polyvalente', methods: ['GET'])]
    public function polyvalente(): Response
    {
        return $this->render('page/home.html.twig', [
            'title' => 'Salles polyvalentes',
        ]);
    }
    #[Route('/gymnase', name: 'gymnase', methods: ['GET'])]
    public function gymnase(): Response
    {
        return $this->render('page/home.html.twig', [
            'title' => 'Gymnase',
        ]);
    }
    #[Route('/sans', name: 'sans', methods: ['GET'])]
    public function sans(): Response
    {
        return $this->render('page/home.html.twig', [
            'title' => 'Sans Catégorie',
        ]);
    }

    #[Route('/email', name: 'email')]
    public function email(): Response
    {
        return $this->render('registration/confirmation_email.html.twig', [
            // 'signedUrl' => 'https://example.com/signed-url',
            // 'expiresAtMessageKey' => 'The URL will expire at %expiresAt%',
        ]);
    }
}
