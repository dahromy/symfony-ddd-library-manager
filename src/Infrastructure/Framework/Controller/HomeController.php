<?php

namespace App\Infrastructure\Framework\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(): Response
    {
        $featuredBooks = [
            ['title' => 'To Kill a Mockingbird', 'author' => 'Harper Lee'],
            ['title' => '1984', 'author' => 'George Orwell'],
            ['title' => 'Pride and Prejudice', 'author' => 'Jane Austen'],
        ];

        return $this->render('home/index.html.twig', [
            'featuredBooks' => $featuredBooks,
        ]);
    }
}
