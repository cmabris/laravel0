<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserQuery extends Builder
{
    public function findByEmail($email)
    {
        return static::where('email', $email)->first();
    }

    public function filterBy(array $filters)
    {
        $rules = [
            'search' => 'filled',
            'state' => 'in:active,inactive',
            'role' => 'in:user,admin',
        ];

        $validator = Validator::make($filters, $rules);

        foreach ($validator->valid() as $name => $value) {
            $method = 'filterBy' . Str::studly($name);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }

        return $this;
    }

    public function filterBySearch($search)
    {
        if (empty($search)) {
            return $this;
        }

        return $this->where(function($query) use ($search) {
            $query->whereRaw('CONCAT(first_name, " ", last_name) like ?', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhereHas('team', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                });
        });

    }

    public function filterByState($state)
    {
        if ($state == 'active') {
            return $this->where('active', true);
        }

        if ($state == 'inactive') {
            return $this->where('active', false);
        }

        return $this;
    }

    public function filterByRole($role)
    {
        if (in_array($role, ['admin', 'user'])) {
            return $this->where('role', $role);
        }

        return $this;
    }
}