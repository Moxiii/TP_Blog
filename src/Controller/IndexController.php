<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ArticleRepository;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'articles'=>$articles
        ]);
    }
}
