<div class="modal fade" id="profile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">User Profile</h1>
            </div>
            <div class="modal-body">
                <label for="fullName">Name</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control-plaintext" placeholder="Full name" name="name"
                        id="fullName" value="{{ auth()->user()->name }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <label for="role">Role</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control-plaintext" placeholder="Role" name="name" readonly
                        id="role" value="{{ auth()->user()->role }}">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
                <label for="Email">Email </label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control-plaintext" placeholder="email" id="email"
                        value="{{ auth()->user()->email }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
