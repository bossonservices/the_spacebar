<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Article;

class ArticleController extends AbstractController
{
    /**
	 * @Route("/", name="app_homepage")
	 */
	public function homepage(ArticleRepository $repository)
	{
	    $articles = $repository->findAllPublishedOrderedByNewest();
		return $this->render('article/homepage.html.twig', [
		    'articles' => $articles,
        ]);

	}

	/**
	 * @Route("/news/{slug}", name="article_show")
	 */
	public function show(Article $article)
	{
	    if ($article->getSlug() === 'khaaaaan'){
            echo "test";
        }

		return $this->render('article/show.html.twig', [
			'article' => $article,
		]);
	}
	
	/**
     	 * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
         */
    	public function toggleArticleHeart(Article $article, LoggerInterface $logger, EntityManagerInterface $em)
    	{
    	    $article->incrementHeartCount();
    	    $em->flush();

            $logger->info('Article is being hearted!');
		return new JsonResponse(['hearts' => $article->getHeartCount()]);
	}	
}
