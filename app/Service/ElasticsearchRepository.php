<?php

namespace App\Service;

use App\Models\Book;
use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class ElasticsearchRepository implements SearchRepository
{
    /** @var Client */
    private $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function search(string $query = ''): Collection
    {
        $items = $this->searchOnElasticsearch($query);
        return $this->buildCollection($items);
    }

    private function searchOnElasticsearch(string $query = ''): array
    {
        $model = new Book();
        $s = [
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => ['title', 'description'],
                        'query' => $query,
                    ],
                ],
            ],
        ];

        $items = $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => ['title', 'description'],
                        'query' => $query,
                    ],
                ],
            ],
        ]);

        return $items;
    }

    private function buildCollection(array $items): Collection
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');
        return Book::findMany($ids)
            ->sortBy(function ($book) use ($ids) {
                return array_search($book->getKey(), $ids);
            });
    }
}
