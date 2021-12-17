<?php

namespace App\Http\Livewire;

use Livewire\Component;

class UsersList extends Component
{
    protected $users;
    protected $view;
    protected $skills;
    protected $checkedSkills;
    protected $sortable;

    public function mount($users, $view, $skills, $checkedSkills, $sortable)
    {
        $this->users = $users;
        $this->view = $view;
        $this->skills = $skills;
        $this->checkedSkills = $checkedSkills;
        $this->sortable = $sortable;
    }

    public function render()
    {
        return view('livewire.users-list', [
            'users' => $this->users,
            'view' => $this->view,
            'skills' => $this->skills,
            'checkedSkills' => $this->checkedSkills,
            'sortable' => $this->sortable,
        ]);
    }
}
