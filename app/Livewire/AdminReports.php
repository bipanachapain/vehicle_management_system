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
          $this->users = User::withCount('vehicles')->get();
    }
    public function render()
    {
        return view('livewire.admin-reports')->layout('layouts.admin.admin');
    }
}
