<main class="main-content position-relative border-radius-lg ">
       
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="container-fluid py-4">
    <div class="card mb-4">
        <div class="card-header pb-0">
            <h6>Vehicles of {{ $user->name }}</h6>
        </div>
        <div class="card-body">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th>Vehicle Name</th>
                        <th>Type</th>
                        <th>Purchase Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicles as $vehicle)
                        <tr>
                            <td>{{ $vehicle->name }}</td>
                            <td>{{ $vehicle->vehicleType->name ?? 'N/A' }}</td>
                            <td>{{ $vehicle->purchase_date }}</td>
                            <td>
                                <a href="{{ route('admin.vehicle.renewables', $vehicle->id) }}" class="btn btn-sm btn-secondary">
                                    View Renewables
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

      
</main>
