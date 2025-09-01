<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class AdminReports extends Component
{

    public $users;

    public function mount()
    {
        // Eager load relationships
        //   $this->users = User::withCount('vehicles')->get();
    }
    public function render()
    {
        $userView= User::withCount('vehicles')->paginate(10);
        return view('livewire.admin-reports' , compact('userView'))->layout('layouts.admin.admin');
    }
}
