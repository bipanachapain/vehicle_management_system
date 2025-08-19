<main class="main-content position-relative border-radius-lg ">
       
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="container-fluid py-4">
  <div class="container-fluid py-4">
    <div class="card mb-4">
        <div class="card-header pb-0">
            <h6>Renewables for {{ $vehicle->name }}</h6>
        </div>
        <div class="card-body">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th>Document</th>
                        <th>Renew Date</th>
                        <th>Expire Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($renewables as $r)
                        <tr>
                            <td>{{ $r->documentType->name ?? 'N/A' }}</td>
                            <td>{{ $r->renewable_date }}</td>
                            <td>{{ $r->expired_date }}</td>
                            <td>
                                <span class="badge bg-{{ $r->status ? 'success' : 'danger' }}">
                                    {{ $r->status ? 'Active' : 'Expired' }}
                                </span>
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
</div>
</main>
