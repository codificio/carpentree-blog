<?php

namespace Carpentree\Blog\Http\Controllers\Admin;

use Carpentree\Blog\Builders\Article\ArticleBuilderInterface;
use Carpentree\Blog\Http\Requests\CreateArticleRequest;
use Carpentree\Blog\Http\Requests\UpdateArticleRequest;
use Carpentree\Blog\Http\Resources\ArticleResource;
use Carpentree\Blog\Models\Article;
use Carpentree\Blog\Services\Listing\Article\ArticleListingInterface;
use Carpentree\Core\Http\Controllers\Controller;
use Carpentree\Core\Http\Requests\Admin\ListRequest;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class ArticleController extends Controller
{

    /** @var ArticleListingInterface */
    protected $listingService;

    /** @var ArticleBuilderInterface */
    protected $builder;

    public function __construct(ArticleListingInterface $listingService, ArticleBuilderInterface $builder)
    {
        $this->listingService = $listingService;
        $this->builder = $builder;
    }

    /**
     * @param ListRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function list(ListRequest $request)
    {
        if (!Auth::user()->can('articles.read')) {
            throw UnauthorizedException::forPermissions(['articles.read']);
        }

        $articles = $this->listingService->list($request);
        return ArticleResource::collection($articles);
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

        return ArticleResource::make(Article::findOrFail($id));
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

        $builder = $this->builder->init()->create($request->input('attributes'));

        if ($request->has('relationships.categories')) {
            $_data = $request->input('relationships.categories.data');
            $_ids = collect($_data)->pluck('id');
            $builder->withCategories($_ids->toArray());
        }

        if ($request->has('relationships.meta')) {
            $_data = $request->input('relationships.meta.data', array());
            $_attributes = collect($_data)->pluck('attributes')->toArray();
            $builder->withMeta($_attributes);
        }

        if ($request->has('relationships.media')) {
            $_data = $this->collectMediaByTagFromRequest($request->input('relationships.media.data', array()));
            $builder->withMedia($_data);
        }

        $article = $builder->build();

        return ArticleResource::make($article->load(['meta', 'categories']))
            ->response()->setStatusCode(201);
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

        /** @var Article $article */
        $article = Article::findOrFail($request->input('id'));

        $builder = $this->builder->init($article);

        if ($request->has('attributes')) {
            $builder->create($request->input('attributes'));
        }

        if ($request->has('relationships.categories')) {
            $_data = $request->input('relationships.categories.data');
            $_ids = collect($_data)->pluck('id');
            $builder->withCategories($_ids->toArray());
        }

        if ($request->has('relationships.meta')) {
            $_data = $request->input('relationships.meta.data', array());
            $_attributes = collect($_data)->pluck('attributes')->toArray();
            $builder->withMeta($_attributes);
        }

        if ($request->has('relationships.media')) {
            $_data = $this->collectMediaByTagFromRequest($request->input('relationships.media.data', array()));
            $builder->withMedia($_data);
        }

        $article = $builder->build();

        return ArticleResource::make($article->load(['meta', 'categories']));
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

    /**
     * @param array $data
     * @return array
     */
    protected function collectMediaByTagFromRequest(array $data)
    {
        $collection = [];

        foreach ($data as $item) {
            if (array_key_exists('meta', $item)) {
                $meta = $item['meta'];
                $tag = array_key_exists('tag', $meta) ? $meta['tag'] : 'default';
            } else {
                $tag = 'default';
            }

            $collection[$tag][] = $item['id'];
        }

        return $collection;
    }

}
