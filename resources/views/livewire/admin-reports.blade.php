<main class="main-content position-relative border-radius-lg ">
       
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="container-fluid py-4">
                <h2 class="text-xl font-bold mb-4 text-center">Users Report</h2>
    <div class="card mb-4">
        {{-- <h6 class="text-xl font-bold mb-4 text-center">Users Report</h6> --}}
        {{-- <div class="card-header pb-0">
            
        </div> --}}
        <div class="card-body">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Vehicles Count</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($userView as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-info">{{ $user->vehicles_count }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.user.vehicles', $user->id) }}" class="btn btn-sm btn-primary">
                                    View Vehicles
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


        </div>
    </div>
</div>
<div class="mt-3">
    {{ $userView->links() }}
</div>
      
</main>
