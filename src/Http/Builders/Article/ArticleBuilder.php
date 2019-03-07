<?php

namespace Carpentree\Blog\Http\Builders\Article;

use Carpentree\Blog\Models\Article;
use Carpentree\Core\Http\Builders\BaseBuilder;

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
