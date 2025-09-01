
<main class="main-content position-relative border-radius-lg ">
       
<div class="container-fluid py-4">

           <div class="card shadow">
    <div class="card-header border-0 text-center">
        <h3 class="mb-0">Manage User Roles</h3>
    </div>
    @if(session()->has('message'))
        <div class="alert alert-success m-3">{{ session('message') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Current Role</th>
                    <th scope="col">Change Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="text-sm">{{ $user->name }}</td>
                        <td class="text-sm">{{ $user->email }}</td>
                        <td>
                            <span class="badge 
                                @if($user->role == 'admin') bg-danger

                                @else bg-info @endif
                            ">
                                {{$user->role}}
                            </span>
                        </td>
                        <td>
                            <select wire:change="updateRole({{ $user->id }}, $event.target.value)" 
                                    class="form-control form-control-sm">
                                @foreach($roles as $role)
                                    <option value="{{ $role }}" {{ $user->role == $role ? 'selected' : '' }}>
                                       {{ $role}}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    
           </div>

</div>
</main>
