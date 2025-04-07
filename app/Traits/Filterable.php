<?php

namespace App\Traits;

use App\Helpers\QueryFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilter($query, QueryFilter $filters): Builder
    {
        return $filters->apply($query);
    }
}
