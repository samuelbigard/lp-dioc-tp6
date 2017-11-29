<?php

namespace App\Article;

use App\Entity\Article;
use App\Entity\ArticleStat;
use App\Slug\SlugGenerator;

class UpdateArticleHandler
{
    public $slugGenerator;

    /**
     * NewArticleHandler constructor.
     * @param $tokenStorage
     * @param $slugGenerator
     */
    public function __construct(SlugGenerator $slugGenerator)
    {
        $this->slugGenerator = $slugGenerator;
    }

    public function handle(Article $article)
    {
        $article->setSlug($this->slugGenerator->generate($article->getTitle()));
        // Slugify le titre et met à jour la date de mise à jour de l'article
        // Log également un article stat avec pour action update.
    }
}
