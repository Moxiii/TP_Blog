<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/article/new', name: 'nouvel_article')]
    public function new(Request $request, Security $security , EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $user = $security->getUser();
        $titre = $request->request->get('titre');
        $text = $request->request->get('text');
        if ($user !== null) {
            $article->setAuteur($user->getUsername());
            $article->setDate(new \DateTime());
        }
        if (!empty($titre) && !empty($text)) {
            $article->setTitre($titre);
            $article->setText($text);
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('app_index');
        }
        return $this->render('article/new.html.twig');
    }


}
