<?php

namespace Carpentree\Blog\Listing\Article;

use Carpentree\Blog\Models\Article;
use Carpentree\Core\Listing\BaseListing;

class ArticleListing extends BaseListing implements ArticleListingInterface
{
    public function __construct()
    {
        $this->model = Article::class;
        $temp = new Article();
        $this->table = $temp->getTable();
    }
}
