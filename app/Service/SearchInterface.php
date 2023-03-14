<?php

namespace App\Service;

use Illuminate\Database\Eloquent\Collection;

interface SearchInterface
{
    public function search(string $query = ''): Collection;
}
