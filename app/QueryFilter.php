<?php

namespace App;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

abstract class QueryFilter
{
    private $valid;

    abstract public function rules(): array;

    public function applyto($query, array $filters)
    {
        $rules = $this->rules();

        $validator = Validator::make(array_intersect_key($filters, $rules), $rules);

        $this->valid = $validator->valid();

        foreach ($this->valid as $name => $value) {
            $this->applyFilters($query, $name, $value);
        }

        return $query;
    }

    private function applyFilters($query, $name, $value): void
    {
        $method = Str::camel($name);

        if (method_exists($this, $method)) {
            $this->$method($query, $value);
        } else {
            $query->where($name, $value);
        }
    }

    public function valid()
    {
        return $this->valid;
    }
}