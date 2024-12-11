@extends('layouts.app')

@section('title')
    {{ $data->policynumber }}
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                @if (session('success'))
                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                        <div>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <div>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="d-flex">
                                    <div class="col-md-3">
                                        <label for="">Status</label>
                                        <p>{{ $data->status }}</p>
                                    </div>
                                    {{--  hidden field  --}}
                                    <div class="form-group" hidden>
                                        <input type="text" value="{{ Auth::user()->name }}" name="check_in_by">
                                    </div>
                                    {{--  hidden field  --}}
                                    <div class="col-md-3">
                                        <label for="">Surname</label>
                                        <input type="text" value=" {{ $data->surname }}" class="form-control-plaintext"
                                            name="surname" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">OtherName</label>
                                        <input type="text" value=" {{ $data->othername }}" class="form-control-plaintext"
                                            name="othername" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Date of Birth</label>
                                        <input type="date" value="{{ $data->DateOfBirth }}"
                                            class="form-control-plaintext" name="DateOfBirth" readonly>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="d-flex">
                                    <div class="col-md-3">
                                        <label for="">Gender</label>
                                        <input type="text" value="{{ $data->gender }}" class="form-control-plaintext"
                                            readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Phone</label>
                                        <input type="text" value="{{ $data->phone }}" class="form-control-plaintext"
                                            name="phone" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Email</label>
                                        <input type="text" value="{{ $data->email }}" class="form-control-plaintext"
                                            name="email" readonly>
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
                                        <input type="text" value="{{ $data->StartDate }}" class="form-control-plaintext"
                                            name="StartDate" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">End date</label>
                                        <input type="text" value="{{ $data->EndDate }}" class="form-control-plaintext"
                                            name="EndDate" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Policy Status</label>
                                        <input type="text" class="form-control-plaintext" value="{{ $data->status }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="d-flex">
                                    <div class="col-md-3">
                                        <label for="clienttype">Client type</label>
                                        <input type="text" class="form-control-plaintext"
                                            value="{{ $data->clienttype }}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Plan Type</label>
                                        <input type="text" class="form-control-plaintext" value="{{ $data->plantype }}"
                                            readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="policytype">Policy Type</label>
                                        <input type="text" class="form-control-plaintext"
                                            value="{{ $data->policytype }}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Enrollee Type </label>
                                        <input type="text" class="form-control-plaintext"
                                            value="{{ $data->enrolleetype }}" readonly>
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
                                        {{ $data->othername }} </br> ({{ $data->policynumber }})
                                    </p>
                                </caption>
                                <input type="file" name="passport" value="{{ $data->passport }}"
                                    class="img w-100 h-100 form-control" hidden>
                            </figure>
                            <form action="{{ route('request.store') }}" method="post">
                                @csrf
                                <input type="text" value="{{ $data->policynumber }}" class="w-100 h-100 form-control"
                                    hidden name="client_id">
                                @error('client_id')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                                {{--  hidden field  --}}
                                <div class="form-group" hidden>
                                    <input type="text" value="{{ Auth()->user()->name }}" name="check_in_by">
                                </div>
                                <div class="form-group" hidden>
                                    <input type="text" value="{{ Auth()->user()->id }}" name="user_id">
                                </div>
                                @error('check_in_by')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                                {{--  hidden field  --}}
                                <button class="btn btn-success w-100" type="submit">Check-In</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Principal Name</th>
                                <th>Principal ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $data->principal }}</td>
                                <td>{{ $data->principal_ID }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection
