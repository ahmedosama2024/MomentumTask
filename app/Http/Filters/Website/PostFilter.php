<?php

namespace App\Http\Filters\Website;

use App\Helpers\QueryFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class PostFilter extends QueryFilter
{
    public function title (string $title = ''): Builder
    {
        return $title != '' ? $this->builder->byTitle($title) : $this->builder;
    }

    public function author (string $authorName = ''): Builder
    {
        return $authorName != '' ? $this->builder->byAuthor($authorName) : $this->builder;
    }

    public function content (string $content = ''): Builder
    {
        return $content != '' ? $this->builder->byContent($content) : $this->builder;
    }
}
