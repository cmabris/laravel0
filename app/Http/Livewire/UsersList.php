<?php

namespace App\Http\Livewire;

use App\Skill;
use App\Sortable;
use App\User;
use App\UserFilter;
use Illuminate\Http\Request;
use Livewire\Component;

class UsersList extends Component
{
    public $view;
    public $originalUrl;
    public $search;
    public $state;
    public $role;
    public $skills = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'state' => ['except' => 'all'],
        'role' => ['except' => 'all'],
        'skills' => [],
    ];

    public function mount($view, Request $request)
    {
        $this->view = $view;

        $this->originalUrl = $request->url();
    }

    protected function getUsers(UserFilter $userFilter)
    {
        $users = User::query()
            ->with('team', 'skills', 'profile.profession')
            ->when(request('team'), function ($query, $team) {
                if ($team === 'with_team') {
                    $query->has('team');
                } elseif ($team === 'without_team') {
                    $query->doesntHave('team');
                }
            })
            ->filterBy($userFilter, array_merge(
                ['trashed' => request()->routeIs('users.trashed')],
                ['state' => $this->state,
                 'role' => $this->role,
                 'search' => $this->search,
                 'skills' => $this->skills,
                 'from' => request('from'),
                 'to' => request('to'),
                 'order' => request('order'),
                 'direction' => request('direction')]

            ))
            ->orderByDesc('created_at')
            ->paginate();

        $users->appends($userFilter->valid());

        return $users;
    }

    public function render(UserFilter $userFilter)
    {
        $sortable = new Sortable($this->originalUrl);

        $this->view = 'index';

        return view('livewire.users-list', [
            'users' => $this->getUsers($userFilter),
            'view' => $this->view,
            'skillsList' => Skill::getList(),
            'checkedSkills' => collect(request('skills')),
            'sortable' => $sortable,
        ]);
    }
}
