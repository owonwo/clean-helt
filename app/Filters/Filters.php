<?php
/**
 * Created by PhpStorm.
 * User: Tammy
 * Date: 28/12/2017
 * Time: 16:41
 */

namespace App\Filters;


use Illuminate\Http\Request;

abstract class Filters
{
    protected $request,$builder;
    protected $filters = [];

    /**
     * ThreadFilters constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;
        foreach ($this->getFilters() as $filter => $value){
            if (method_exists($this,$filter)){
                $this->$filter($value);
            }
            $this->$filter($this->request->$filter);

        }


        return $this->builder;

    }

    /**
     * @param $filter
     * @return bool
     */

    public function getFilters(){
        return $this->request->only($this->filters);
    }
}