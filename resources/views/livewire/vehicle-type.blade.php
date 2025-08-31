<main class="main-content position-relative border-radius-lg ">
       
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
    <div class="card-header border-0">
        <h2 class="mb-0 text-center" >Vehicle Type Management</h2>
    </div>
    <div class="card-body">

        {{-- Success Message --}}
        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        {{-- Form --}}
        <form wire:submit.prevent="store" class="form-inline mb-4">
            <div class="form-group mb-2 mr-2 flex-fill">
                <input type="text"
                       wire:model="name"
                       placeholder="Vehicle Type Name"
                       class="form-control w-100" />
            </div>
            <button type="submit"
                    class="btn {{ $type_id ? 'btn-warning' : 'btn-primary' }}">
                {{ $type_id ? 'Update' : 'Create' }}
            </button>
        </form>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($vehicleTypes as $type)
                        <tr>
                            <td>{{ $type->id }}</td>
                            <td>{{ $type->name }}</td>
                            <td class="text-center">
                                <button wire:click="edit({{ $type->id }})"
                                        class="btn btn-sm btn-warning">
                                    Edit
                                </button>
                                <button wire:click="delete({{ $type->id }})"
                                        onclick="return confirm('Delete this type?')"
                                        class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">No vehicle types found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
            </div>
          </div>
    </div>
</div>

      
</main>  

