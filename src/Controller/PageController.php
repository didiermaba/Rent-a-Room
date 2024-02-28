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

    #[Route('/account', name: 'account', methods: ['GET', 'POst'])]
    public function account(): Response
    {
        return $this->render('page/account.html.twig', [
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
