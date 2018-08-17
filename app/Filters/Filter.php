<?php

namespace App\Filters;


use Illuminate\Http\Request;

abstract class Filter
{
    protected $request, $builder, $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {

        $this->builder = $builder;
        foreach ($this->getFilters() as $filter => $value) {

            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return collect($this->request)->intersectByKeys(
            collect($this->filters)->flip()->toArray()
        )->toArray();
    }
}