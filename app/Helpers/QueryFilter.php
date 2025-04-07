<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Database\Eloquent\Builder;

abstract class QueryFilter
{
    protected $request;
    protected $builder;
    protected $availableBooleanValues = [
        'yes' => 1,
        'no' => 0
    ];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            if (method_exists($this, $name)) {
                call_user_func_array([$this, $name], array_filter([$value]));
            }
        }
        return $this->builder;
    }

    public function filters(): array
    {
        return $this->request->all();
    }
}
