<?php

namespace Carpentree\Blog\Builders\Article;

use Carpentree\Blog\Models\Article;
use Carpentree\Core\Builders\BaseBuilder;

class ArticleBuilder extends BaseBuilder implements ArticleBuilderInterface
{

    /**
     * @return mixed
     */
    protected function getClass()
    {
        return Article::class;
    }
}
