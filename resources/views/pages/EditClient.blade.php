@extends('layouts.app')

@section('title')
    {{ $data->policynumber }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid bg-white  d-flex justify-content-between">
            <a href="{{ route('client.index') }}" class="btn btn-primary float-end m-3 floating-end">Back</a>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('client.update', $data->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="d-flex">
                                            <div class="col-md-3">
                                                <label for="">Status</label>
                                                <p>{{ $data->status }}</p>
                                            </div>
                                            {{--  hidden field  --}}
                                            <div hidden>
                                                <input type="text" value="self" placeholder="PrincipalName"
                                                    name="PrincipalName">
                                                <input type="text" value="self" placeholder="PrincipalNumber"
                                                    name="PrincipalNumber">
                                                <input type="text" value="self" placeholder="PrincipalRelationship"
                                                    name="PrincipalRelationship">
                                            </div>
                                            {{--  hidden field  --}}
                                            <div class="col-md-3">
                                                <label for="">Surname</label>
                                                <input type="text" value=" {{ $data->surname }}"
                                                    class="form-control-plaintext" name="surname">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">OtherName</label>
                                                <input type="text" value=" {{ $data->othername }}"
                                                    class="form-control-plaintext" name="othername">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">Date of Birth</label>
                                                <input type="date" value="{{ $data->DateOfBirth }}"
                                                    class="form-control-plaintext" name="DateOfBirth">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="d-flex">
                                            <div class="col-md-3">
                                                <label for="">Gender</label>
                                                <select name="gender" id="gender" class="form-control-plaintext">
                                                    <option value="">Select Gender</option>
                                                    <option value="Male"{{ $data->gender == 'Male' ? 'selected' : '' }}>
                                                        Male
                                                    </option>
                                                    <option value="Female"{{ $data->gender == 'Female' ? 'selected' : '' }}>
                                                        Female
                                                    </option>

                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">Phone</label>
                                                <input type="text" value="{{ $data->phone }}"
                                                    class="form-control-plaintext" name="phone">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Email</label>
                                                <input type="text" value="{{ $data->email }}"
                                                    class="form-control-plaintext" name="email">
                                            </div>

                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="d-flex">
                                            <div class="col-md-3">
                                                <label for="">Policy Number</label>
                                                <input type="text" value="{{ $data->policynumber }}"
                                                    class="form-control-plaintext" name="policynumber" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">Start Date</label>
                                                <input type="text" value="{{ $data->StartDate }}"
                                                    class="form-control-plaintext" name="StartDate">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">End date</label>
                                                <input type="text" value="{{ $data->EndDate }}"
                                                    class="form-control-plaintext" name="EndDate">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">Policy Status</label>
                                                <select name="status" id="status" class="form-control-plaintext">
                                                    <option value="">select</option>
                                                    <option value="Active"
                                                        {{ $data->status == 'Active' ? 'selected' : '' }}>
                                                        Active
                                                    </option>
                                                    <option value="Inactive"
                                                        {{ $data->status == 'Inactive' ? 'selected' : '' }}>
                                                        Inactive
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="d-flex">
                                            <div class="col-md-3">
                                                <label for="">Client type</label>
                                                <select name="clienttype" id="clienttype" class="form-control-plaintext">
                                                    <option value="Corperate"
                                                        {{ $data->clienttype == 'Corperate' ? 'selected' : '' }}>Corperate
                                                    </option>
                                                    <option value="Private"
                                                        {{ $data->clienttype == 'Private' ? 'selected' : '' }}>Private
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">Plan Type</label>
                                                <select name="plantype" id="plantype" class="form-control-plaintext">
                                                    <option>Select from the list below</option>
                                                    <option value="Individual Plan"
                                                        {{ $data->plantype == 'Individual Plan' ? 'selected' : '' }}>
                                                        Individual
                                                        Plan</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="policytype">Policy Type</label>
                                                <select name="policytype" id="policytype" class="form-control-plaintext">
                                                    <option
                                                        value="Family Plan"{{ $data->policytype == 'Family Plan' ? 'selected' : '' }}>
                                                        Family Plan</option>
                                                    <option
                                                        value="Individual Plan"{{ $data->policytype == 'Individual Plan' ? 'selected' : '' }}>
                                                        Individual Plan</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">Enrollee Type </label>
                                                <input type="text" value="{{ $data->enrolleetype }}"
                                                    class="form-control-plaintext" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <figure class="card b-2 roundered" style="border-radius: 3px">
                                        <img src="{{ asset($data->passport) }}" alt="" class="img w-100 h-100">
                                        <caption class="mt-1">
                                            <hr>
                                            <p class="text-center">{{ $data->surname }},
                                                {{ $data->othername }} ({{ $data->policynumber }})
                                            </p>
                                        </caption>
                                        <input type="file" name="passport" value="{{ $data->passport }}"
                                            class="img w-100 h-100 form-control">
                                    </figure>
                                    <button class="btn btn-success w-100">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @if ($data->enrolleetype === 'Principal')
                    <div class="card">
                        <div class="card-body">
                            <p>Dependents</p>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Enrollee Number</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Relationship</th>
                                        <th>Principal Name</th>
                                        <th>Principal ID</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($dependents as $item)
                                        <tr>
                                            <td>{{ $item->policynumber }}</td>
                                            <td>{{ $item->surname }}, {{ $item->othername }}</td>
                                            <td>{{ $item->gender }}</td>
                                            <td>{{ $item->PrincipalRelationship }}</td>
                                            <td>{{ $item->PrincipalName }}</td>
                                            <td>{{ $item->PrincipalNumber }}</td>
                                            <td>{{ $item->status }}</td>
                                        </tr>
                                    @empty
                                        <div class="alert-danger text-center">
                                            Client does not have any dependent
                                        </div>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                @endif

            </div>
        </section>
    </div>
@endsection
