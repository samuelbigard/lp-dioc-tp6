<?php

namespace App\Controller;

use App\Article\CountViewUpdater;
use App\Article\NewArticleHandler;
use App\Article\UpdateArticleHandler;
use App\Article\ViewArticleHandler;
use App\Entity\Article;
use App\Form\ArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route(path="/article")
 */
class ArticleController extends Controller
{
    /**
     * @Route(path="/show/{slug}", name="article_show")
     */
    public function showAction(ViewArticleHandler $viewArticleHandler, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Article::class);
        $article = $repo->findOneBy(array(
           "slug" => $slug
        ));

        return $this->render("Article/show.html.twig", array("article"=>$article));
    }

    /**
     * @Security("is_granted('ROLE_AUTHOR')")
     * @Route(path="/new", name="article_new")
     */
    public function newAction(Request $request,NewArticleHandler $newArticleHandler)
    {
        // Seul les auteurs doivent avoir access.
        $article = new Article();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $newArticleHandler->handle($article);
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute("article_show", array("slug"=>$article->getSlug()));
        }
        return $this->render("Article/new.html.twig", array("form"=>$form->createView()));
    }

    /**
     * @Route(path="/update/{slug}", name="article_update")
     */
    public function updateAction(Request $request, UpdateArticleHandler $updateArticleHandler, $slug)
    {
        // Seul les auteurs doivent avoir access.
        // Seul l'auteur de l'article peut le modifier
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Article::class);
        $article = $repo->findOneBy(array(
            "slug" => $slug
        ));

        if($this->getUser() != $article->getAuthor()){
            return $this->redirectToRoute("article_show", array("slug"=>$article->getSlug()));
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $updateArticleHandler->handle($article);
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute("article_show", array("slug"=>$article->getSlug()));
        }
        return $this->render("Article/update.html.twig", array("form"=>$form->createView()));
    }
}
