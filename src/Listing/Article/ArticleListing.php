<?php

namespace Carpentree\Blog\Listing\Article;

use Carpentree\Blog\Models\Article;
use Carpentree\Core\Listing\AlgoliaBaseListing;

class ArticleListing extends AlgoliaBaseListing implements ArticleListingInterface
{
    public function __construct()
    {
        $this->model = Article::class;
        $temp = new Article();
        $this->table = $temp->getTable();
    }
}
