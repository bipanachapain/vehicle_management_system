<?php

namespace App\Livewire;

use App\Models\User;
use App\Enums\UserRole;
use Livewire\Component;
use function Livewire\Volt\layout;

class UserRoles extends Component
{
    public function mount(){
         $this->users = User::all();
        $this->roles = User::select('role')->distinct()->pluck('role')->toArray();
    }
    public function render()
    {
       $users= $this->users = User::all();
        $roles = UserRole::cases();
        return view('livewire.user-roles' , compact( 'users','roles'))->layout('layouts.admin.admin');
    }

    public function updateRole($userId, $role)
    {
         $user = User::findOrFail($userId);
        $user->role = $role;
        $user->save();
      session()->flash('message', 'User role updated successfully.');
    }
}
