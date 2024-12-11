@extends('layouts.app')

@section('title')
    Clients
@endsection


@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
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
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"></h1>
                    </div>
                    <!-- /.col -->
                    @if (auth()->user()->role === 'Admin')
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><button type="button" class="btn btn-secondary"
                                        data-bs-toggle="modal" data-bs-target="#register">
                                        Register New Client
                                    </button>
                                </li>
                            </ol>
                        </div>
                    @endif
                </div>
            </div>
            <!-- /.content-header -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">List of Registered Clients</h3>
                                    <div class="col-md-8 float-end">
                                        <form action="{{ route('search.client') }}" method="GET">
                                            <div class="form-group  d-flex">
                                                <input type="text" name="query" id="query"
                                                    value="{{ request('query') }}" class="form-control"
                                                    placeholder="Search ...">
                                                <button class="btn btn-primary">Search</button>
                                                @if (request('query'))
                                                    <a href="{{ route('client.index') }}"
                                                        class="btn btn-secondary ml-2">Clear</a>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Enrollee Number</th>
                                                <th>Surname</th>
                                                <th>Other Names</th>
                                                <th>Enrollee Type</th>
                                                <th colspan="2" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($query) && $query)
                                                <h4>Search results for "{{ $query }}":</h4>
                                                @if ($result->isEmpty())
                                                    <p>No results found for "{{ $query }}".</p>
                                                @else
                                                    @forelse ($result as $item)
                                                        <tr>
                                                            <td>
                                                                <a href="{{ route('client.show', $item->id) }}"
                                                                    class="btn btn-primary">
                                                                    {{ $item->policynumber }}</a>
                                                            </td>
                                                            <td>{{ $item->surname }} </td>
                                                            <td>{{ $item->othername }}</td>
                                                            <td> {{ $item->enrolleetype }}</td>
                                                            <td class="d-flex">
                                                                <form action="{{ route('client.destroy', $item->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Are you sure you want to delete this Procedure?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $item->id }}">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Delete</button>
                                                                </form>
                                                                <a href="{{ route('client.edit', $item->id) }}"
                                                                    class="btn btn-primary">Edit</a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="7">
                                                                <div class="alert-primary text-center"> No record To Display
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                @endif
                                            @else
                                                @forelse ($credentials as $item)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('client.show', $item->id) }}"
                                                                class="btn btn-primary">
                                                                {{ $item->policynumber }}</a>
                                                        </td>
                                                        <td>{{ $item->surname }} </td>
                                                        <td>{{ $item->othername }}</td>
                                                        <td> {{ $item->enrolleetype }}</td>
                                                        <td class="d-flex">
                                                            <form action="{{ route('client.destroy', $item->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Are you sure you want to delete this Procedure?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="id"
                                                                    value="{{ $item->id }}">
                                                                <button type="submit"
                                                                    class="btn btn-danger">Delete</button>
                                                            </form>
                                                            <a href="{{ route('client.edit', $item->id) }}"
                                                                class="btn btn-primary">Edit</a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7">
                                                            <div class="alert-primary text-center"> No record To Display
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6">
                                                    <div>
                                                        <link
                                                            href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css"
                                                            rel="stylesheet">
                                                        <div class="">
                                                            {{ $credentials->links('pagination::tailwind') }}
                                                        </div>
                                                        <style>
                                                            link[href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css"] {
                                                                display: none;
                                                            }
                                                        </style>
                                                    </div>

                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </section>
            <x-client-registration />
            <!-- Modal -->
            <div class="modal fade" id="register" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
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
                                        <input type="text" name="othername" class="form-control"
                                            placeholder="othername" id="othername" value="{{ old('othername') }}">
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
                                                <option>Select Gender</option>
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
                                        <input type="file" accept=".jpg, .png, .jepg" class="form-control"
                                            class="form-control" name="passport">
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
                                        <input type="text" name="policynumber" id="policyumber"
                                            placeholder="Policy Number" readonly class="form-control">
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
                                        <input type="date" name="StartDate" id="start" placeholder="start"
                                            required class="form-control">
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
                                            <option>Select from the list below</option>
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
                                            <option>Select from the list below</option>
                                            <option value="Individual Plan">Individual Plan</option>
                                        </select>
                                        @error('plantype')
                                            <div class="alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="policytype">Policy Type </label>
                                        <select name="policytype" id="policytype" class="form-control">
                                            <option>Select from the list below</option>
                                            <option value="Group">Group</option>
                                            <option value="Individual ">Individual</option>
                                        </select>
                                        @error('plantype')
                                            <div class="alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="enrolleetype">Enrollee Type </label>
                                        <input type="text" placeholder="enrolleetype" name="enrolleetype"
                                            class="form-control" value="Principal" readonly>
                                        @error('enrolleetype')
                                            <div class="alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        <input type="text" value="{{ auth()->user()->id }}" name="user_id" hidden>
                                    </div>
                                </div>
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

        </div>
    </div>

@endsection
