<?php

namespace App;

use Illuminate\Support\Facades\DB;

class UserFilter extends QueryFilter
{

    public function rules(): array
    {
        return [
            'search' => 'filled',
            'state' => 'in:active,inactive',
            'role' => 'in:user,admin',
            'skills' => 'array|exists:skills,id'
        ];
    }

    public function filterBySearch($query, $search)
    {
        return $query->where(function($query) use ($search) {
            $query->whereRaw('CONCAT(first_name, " ", last_name) like ?', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhereHas('team', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                });
        });

    }

    public function filterByState($query, $state)
    {
        return $query->where('active', $state == 'active');
    }

    public function filterBySkills($query, $skills)
    {
        $subquery = DB::table('skill_user AS s')
            ->selectRaw('COUNT(s.id)')
            ->whereColumn('s.user_id', 'users.id')
            ->whereIn('skill_id', $skills);

        $query->addBinding($subquery->getBindings());

        $query->where(DB::raw("({$subquery->toSql()})"), count($skills));
    }
}