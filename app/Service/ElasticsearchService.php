<?php

namespace App\Service;

use App\Models\Book;
use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class ElasticsearchService implements SearchInterface
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

        return $this->elasticsearch->search([
            'index' => $model->getTable(),
            'type' => $model->getTable(),
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => ['title^5', 'genre', 'description'],
                        'query' => "$query",
                        "fuzziness" => 3,
                    ]
                ],
            ],
            'size' => 50
        ]);
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
