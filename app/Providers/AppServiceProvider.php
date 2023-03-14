<?php

namespace App\Providers;

use App\Service\SqlSearchService;
use App\Service\ElasticsearchService;
use App\Service\SearchInterface;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->bindSearchRepository();
        $this->bindSearchClient();
    }

    private function bindSearchRepository()
    {
        $this->app->bind(SearchInterface::class, function () {
            if (config('services.search.enabled')) {
                return new ElasticsearchService(
                    $this->app->make(Client::class)
                );
            }

            return new SqlSearchService();
        });
    }

    private function bindSearchClient()
    {
        $this->app->bind(Client::class, function () {
            return ClientBuilder::create()
                ->setHosts(config('services.search.hosts'))
                ->build();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
