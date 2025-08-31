<?php

use App\Livewire\AdminDashboard;
use App\Livewire\AdminReports;
use App\Livewire\MessageComponent;
use App\Livewire\RenewableHistory;
use App\Livewire\RenewableLivewire;
use App\Livewire\UserDashboard;
use App\Livewire\UserRenewableDocument;
use App\Livewire\VehicleLivewire;
use App\Livewire\VehicleRenewables;
use App\Livewire\VehicleReport;
use App\Livewire\VehicleTypeUser;
use App\Livewire\UserNotification;
use Illuminate\Support\Facades\Route;
use App\Livewire\DocumentTypeAdmin;

Route::view('/', 'welcome');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
    
Route::middleware(['auth', 'admin','verified'])->group(function () {
    Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');
     Route::get('/document-types', DocumentTypeAdmin::class)->name('admin.document.types');
    Route::get('/messages', MessageComponent::class)->name('admin.messages');
    Route::get('/admin/reports', AdminReports::class)->name('admin.reports');
    Route::get('/admin/user/{userId}/vehicles', VehicleReport::class)->name('admin.user.vehicles');
    Route::get('/admin/vehicle/{vehicleId}/renewables', VehicleRenewables::class)->name('admin.vehicle.renewables');
    Route::get('/admin/profile', \App\Livewire\AdminProfile::class)->name('admin.profile');
});
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/', UserDashboard::class)->name('user.dashboard');
    Route::get('/vehicle-types', VehicleTypeUser::class)->name('vehicle.types');
    Route::get('/vehicles', VehicleLivewire::class)->name('vehicles.index');
     Route::get('/Renewable', RenewableLivewire::class)->name('renewable.index');
      Route::get('/my-renewables', UserRenewableDocument::class)->name('user.renewables');
      Route::get('/vehicles/{vehicle}/document/{document}/history', RenewableHistory::class)
    ->name('renewable.history');
    Route::get('/user/notifications', UserNotification::class)->name('user.notifications');
    Route::get('/profile', \App\Livewire\UserProfile::class)->name('user.profile');
   

    Route::get('/user/roles', \App\Livewire\UserRoles::class)->name('user.roles');
});

require __DIR__.'/auth.php';
