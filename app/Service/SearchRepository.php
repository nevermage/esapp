<?php

namespace App\Service;

use Illuminate\Database\Eloquent\Collection;

interface SearchRepository
{
    public static function search(string $query = ''): Collection;
}
