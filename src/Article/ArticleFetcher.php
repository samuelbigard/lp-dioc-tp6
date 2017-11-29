<?php

namespace App\Article;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Registry;

class ArticleFetcher
{
    public $registry;

    /**
     * ArticleFetcher constructor.
     * @param $registry
     */
    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

    public function fetch() : array
    {
        $repo = $this->registry->getManager()->getRepository(Article::class);
        $articles = $repo->findBy(array(),array('createdAt' => "DESC"),10);
        return $articles;
    }
}
