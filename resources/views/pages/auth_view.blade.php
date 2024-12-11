@extends('layouts.app')

@section('title')
    Pre-Authorization
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <form action="{{ route('auth_view') }}" method="get">
                            <div class="form-group">
                                <div class="d-flex justify-content-around">
                                    <div class="col-md-10">
                                        <input type="number" placeholder="Search with ID, batch number"
                                            value="{{ request('query') }}" class="form-control" minlength="14" required
                                            name="query">
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-danger">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Batch Id</th>
                                    <th>Enrollee Number</th>
                                    <th>Name</th>
                                    <th>Request By</th>
                                    <th>Request Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($result as $item)
                                    <tr>
                                        <td>{{ $item->batch_id }}</td>
                                        <td>{{ $item->policynumber }}</td>
                                        <td>{{ $item->surname }}, {{ $item->othername }}</td>
                                        <td>{{ $item->user }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <a href="{{ route('batch_request', ['batch_id' => $item->batch_id]) }}"
                                                class="btn btn-primary">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
