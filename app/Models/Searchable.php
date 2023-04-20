<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

trait Searchable
{
    public $searchIndex;

    //TODO implement observer

    /**
     * @param array $items
     * @return Collection
     */
    public static function buildCollection(array $items): Collection
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');

        return self::findMany($ids);
    }
}
