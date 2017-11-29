<?php

namespace App\Article;

use App\Entity\Article;
use App\Entity\ArticleStat;
use App\Slug\SlugGenerator;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class NewArticleHandler
{
    public $tokenStorage;
    public $slugGenerator;

    /**
     * NewArticleHandler constructor.
     * @param $tokenStorage
     * @param $slugGenerator
     */
    public function __construct(TokenStorage $tokenStorage, SlugGenerator $slugGenerator)
    {
        $this->tokenStorage = $tokenStorage;
        $this->slugGenerator = $slugGenerator;
    }


    public function handle(Article $article): void
    {
        // Slugify le titre et ajoute l'utilisateur courant comme auteur de l'article
        // Log également un article stat avec pour action create.
        $article->setSlug($this->slugGenerator->generate($article->getTitle()));
        $article->setAuthor($this->tokenStorage->getToken()->getUser());
    }
}
