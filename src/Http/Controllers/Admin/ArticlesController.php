<?php

namespace Carpentree\Blog\Http\Controllers\Admin;

use Carpentree\Blog\Http\Requests\CreateArticleRequest;
use Carpentree\Blog\Http\Requests\UpdateArticleRequest;
use Carpentree\Blog\Http\Resources\ArticleResource;
use Carpentree\Blog\Models\Article;
use Carpentree\Core\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Exceptions\UnauthorizedException;

class ArticlesController extends Controller
{

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function list()
    {
        if (!Auth::user()->can('articles.read')) {
            throw UnauthorizedException::forPermissions(['articles.read']);
        }

        return ArticleResource::collection(Article::paginate(config('carpentree.pagination.per_page')));
    }

    /**
     * @param $id
     * @return ArticleResource
     */
    public function get($id)
    {
        if (!Auth::user()->can('articles.read')) {
            throw UnauthorizedException::forPermissions(['articles.read']);
        }

        $article = Article::findOrFail($id);

        return ArticleResource::make($article);
    }

    /**
     * @param CreateArticleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateArticleRequest $request)
    {
        if (!Auth::user()->can('articles.create')) {
            throw UnauthorizedException::forPermissions(['articles.create']);
        }

        $article = DB::transaction(function () use ($request) {

            // Article attributes
            $attributes = $request->input('attributes');
            /** @var Article $article */
            $article = Article::create($attributes);

            // Categories relationship
            // Syncronize only if input exists
            if ($request->has('relationships.categories')) {
                $_data = $request->input('relationships.categories.data');

                $categoryIds = array();
                foreach ($_data as $category) {
                    $categoryIds[] = $category['id'];
                }

                $article->syncCategories($categoryIds);
            }

            // Meta fields
            if ($request->has('relationships.meta')) {
                $_data = $request->input('relationships.meta.data', array());
                $article = $article->syncMeta(collect($_data)->pluck('attributes')->toArray());
            }

            return $article;
        });

        return ArticleResource::make($article)->response()->setStatusCode(201);
    }

    /**
     * @param UpdateArticleRequest $request
     * @return ArticleResource
     */
    public function update(UpdateArticleRequest $request)
    {
        if (!Auth::user()->can('articles.update')) {
            throw UnauthorizedException::forPermissions(['articles.update']);
        }

        $article = DB::transaction(function () use ($request) {
            /** @var Article $article */
            $article = Article::findOrFail($request->input('id'));

            // Article attributes
            if ($request->has('attributes')) {
                $attributes = $request->input('attributes');
                $article->update($attributes);
            }

            // Categories relationship
            // Syncronize only if input exists
            if ($request->has('relationships.categories')) {
                $_data = $request->input('relationships.categories.data');

                $categoryIds = array();
                foreach ($_data as $category) {
                    $categoryIds[] = $category['id'];
                }

                $article->syncCategories($categoryIds);
            }

            // Meta fields
            if ($request->has('relationships.meta')) {
                $_data = $request->input('relationships.meta.data', array());
                $article = $article->syncMeta(collect($_data)->pluck('attributes')->toArray());
            }

            return $article;
        });

        return ArticleResource::make($article);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete($id)
    {
        if (!Auth::user()->can('articles.delete')) {
            throw UnauthorizedException::forPermissions(['articles.delete']);
        }

        /** @var Article $article */
        $article = Article::findOrFail($id);

        if ($article->delete()) {
            return response()->json(null, 204);
        } else {
            return response()->json(null, 202);
        }
    }

}
