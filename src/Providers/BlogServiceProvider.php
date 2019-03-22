<?php

namespace Carpentree\Blog\Providers;

use Carpentree\Blog\Builders\Article\ArticleBuilder;
use Carpentree\Blog\Builders\Article\ArticleBuilderInterface;
use Carpentree\Blog\DataAccess\Article\ArticleDataAccess;
use Carpentree\Blog\DataAccess\Article\EloquentArticleDataAccess;
use Carpentree\Blog\Models\Article;
use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerMigrations();

        $this->mapRoutes();

        $this->publishConfig();

        $this->publishResources();
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/blog.php',
            'carpentree.blog'
        );

        $this->mergeConfigFrom(
            __DIR__.'/../../config/permissions.php',
            'carpentree.permissions'
        );

        $this->bindImplementation();
    }

    public function bindImplementation()
    {
        // Article Builder Service
        $this->app->bind(ArticleBuilderInterface::class, ArticleBuilder::class);

        // Article Data Access
        $this->app->bind(ArticleDataAccess::class, function () {
            return new EloquentArticleDataAccess(Article::class);
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapRoutes()
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/api/admin.php');
    }

    public function publishResources()
    {
        $this->publishes([
            __DIR__ . '/../../resources/assets' => resource_path('vendor/carpentree/blog')
        ], 'assets');
    }

    public function publishConfig()
    {
        $this->publishes([
            __DIR__.'/../../config/blog.php' => config_path('carpentree/blog.php'),
        ], 'config');
    }

    /**
     * Register Module's migration files.
     */
    protected function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['blog'];
    }
}
