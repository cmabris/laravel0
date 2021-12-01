<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

class UserQuery extends Builder
{
    use FiltersQuery;

    private function filterRules(): array
    {
        return [
            'search' => 'filled',
            'state' => 'in:active,inactive',
            'role' => 'in:user,admin',
        ];
    }

    public function findByEmail($email)
    {
        return static::where('email', $email)->first();
    }

    public function filterBySearch($search)
    {
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
        return $this->where('active', $state == 'active');
    }
}