<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class UserSearchFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function ($query) use ($value) {
            $query->where('name', 'ilike', "%{$value}%")
                ->orWhere('email', 'ilike', "%{$value}%");
        });
    }
}
