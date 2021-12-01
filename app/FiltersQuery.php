<?php

namespace App;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

trait FiltersQuery
{
    public function filterBy(array $filters)
    {
        $rules = $this->filterRules();

        $validator = Validator::make(array_intersect_key($filters, $rules), $rules);

        foreach ($validator->valid() as $name => $value) {
            $this->applyFilters($name, $value);
        }

        return $this;
    }

    private function applyFilters($name, $value): void
    {
        $method = 'filterBy' . Str::studly($name);

        if (method_exists($this, $method)) {
            $this->$method($value);
        } else {
            $this->where($name, $value);
        }
    }
}