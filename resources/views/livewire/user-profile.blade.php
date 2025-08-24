<main class="main-content position-relative border-radius-lg ">
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="container-fluid py-4">
    <div class="row">
        <!-- Update Profile Information -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-primary">Update Profile Information</h5>
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>
        </div>

        <!-- Update Password -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-primary">Update Password</h5>
                    <livewire:profile.update-password-form />
                </div>
            </div>
        </div>

        <!-- Delete User -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow border-danger">
                <div class="card-body">
                    <h5 class="card-title text-danger">Delete Account</h5>
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</div>

        </div>
    </div>
</div>
</main>