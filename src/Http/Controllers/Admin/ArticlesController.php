<?php

namespace Carpentree\Blog\Http\Controllers\Admin;

use Carpentree\Blog\Http\Resources\ArticleResource;
use Carpentree\Blog\Models\Article;
use Carpentree\Core\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class ArticlesController extends Controller
{

    public function getAll()
    {
        if (!Auth::user()->can('articles.read')) {
            throw UnauthorizedException::forPermissions(['articles.read']);
        }

        return ArticleResource::collection(Article::paginate(config('carpentree.pagination.per_page')));
    }

}
