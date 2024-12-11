<!-- Modal -->
<div class="modal fade" id="Principal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Client Registration for Principal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('client.store') }}" method="Post" enctype="multipart/form-data">
                    @csrf

                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="surname">Surname</label>
                            <input type="text" name="surname" class="form-control" placeholder="Surname"
                                id="surname" value="{{ old('surname') }}">
                            @error('surname')
                                <div class="alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="othername">Other Names</label>
                            <input type="text" name="othername" class="form-control" placeholder="othername"
                                id="othername" value="{{ old('othername') }}">
                            @error('othername')
                                <div class="alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6 d-flex">
                            <div class="col-md-6">
                                <label for="gender">Gender</label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                @error('gender')
                                    <div class="alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="dob">Date of Birth</label>
                                <input type="date" id="dob" placeholder="dob" class="form-control"
                                    name="DateOfBirth">
                                @error('DateOfBirth')
                                    <div class="alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="phone">Phone</label>
                            <input type="tel" name="phone" class="form-control" placeholder="phone"
                                id="phone">
                            @error('phone')
                                <div class="alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="email"
                                id="email">
                            @error('email')
                                <div class="alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="passport">Passport</label>
                            <input type="file" accept=".jpg, .png, .jepg" class="form-control" class="form-control"
                                name="passport">
                            @error('passport')
                                <div class="alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    Policy Data
                    <hr>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="policynumber">Policy Number</label>
                            <input type="text" name="policynumber" id="policyumber" placeholder="Policy Number"
                                readonly class="form-control">
                            @error('policynumber')
                                <div class="alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="policystatus">Policy Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="Active" selected>Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                            @error('status')
                                <div class="alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="start">Start date</label>
                            <input type="date" name="StartDate" id="start" placeholder="start" required
                                class="form-control">
                            @error('StartDate')
                                <div class="alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="end">End Date</label>
                            <input type="date" name="EndDate" id="end" placeholder="end" required
                                class="form-control">
                            @error('EndDate')
                                <div class="alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="clienttype">Client Type </label>
                            <select name="clienttype" id="clienttype" class="form-control">
                                <option value="" selected>Select from the list below</option>
                                <option value="Corperate">Corperate</option>
                                <option value="Private">Private</option>
                            </select>
                            @error('clienttype')
                                <div class="alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="plantype">Plan Type </label>
                            <select name="plantype" id="plantype" class="form-control">
                                <option value="" selected>Select from the list below</option>
                                <option value="Family Plan">Family Plan</option>
                                <option value="Individual Plan">Individual Plan</option>
                            </select>
                            @error('plantype')
                                <div class="alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="policytype">Policy Type </label>
                            <select name="policytype" id="policytype" class="form-control">
                                <option value="" selected>Select from the list below</option>
                                <option value="Group">Group</option>
                                <option value="Individual ">Individual</option>
                            </select>
                            @error('plantype')
                                <div class="alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="enrolleetype">Enrollee Type </label>
                            <select name="enrolleetype" id="enrolleetype" class="form-control" readonly>
                                <option value="Principal" selected>Principal</option>
                                <option value="Dependent ">Dependent</option>
                            </select>
                            @error('enrolleetype')
                                <div class="alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{--  hidden field  --}}
                    <div hidden>
                        <input type="text" value="self" placeholder="PrincipalName" name="PrincipalName">
                        <input type="text" value="self" placeholder="PrincipalNumber" name="PrincipalNumber">
                        <input type="text" value="self" placeholder="PrincipalRelationship"
                            name="PrincipalRelationship">
                    </div>
                    {{--  hidden field  --}}
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-danger">Reset</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
