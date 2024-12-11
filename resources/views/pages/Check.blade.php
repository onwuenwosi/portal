@extends('layouts.app')

@section('title')
    Eligibility Check
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        search for Principal Enrollee
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <form action="{{ route('search.principal') }}" method="GET">
                                                        <div class="form-group  d-flex">
                                                            <input type="text" name="query" id="query"
                                                                value="{{ request('query') }}" class="form-control"
                                                                placeholder="Search ...">
                                                            <button class="btn btn-primary">Search</button>
                                                            @if (request('query'))
                                                                <a href="javascript:history.back()"
                                                                    class="btn btn-secondary ml-2">Clear</a>
                                                            @endif
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="card-body">
                                                    <table id="example2" class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Enrollee Number</th>
                                                                <th>Surname</th>
                                                                <th>Other Names</th>
                                                                <th>Enrollee Type</th>
                                                                <th>Enrollee Status</th>
                                                                <th colspan="3" class="text-center">Action</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Search for Dependents
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <form action="{{ route('search.dependent') }}" method="GET">
                                                        <div class="form-group  d-flex">
                                                            <input type="text" name="query" id="query"
                                                                value="{{ request('query') }}" class="form-control"
                                                                placeholder="Search ...">
                                                            <button class="btn btn-primary">Search</button>
                                                            @if (request('query'))
                                                                <a href="javascript:history.back()"
                                                                    class="btn btn-secondary ml-2">Clear</a>
                                                            @endif
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="card-body">
                                                    <table id="example2" class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Enrollee Number</th>
                                                                <th>Surname</th>
                                                                <th>Other Names</th>
                                                                <th>Enrollee Type</th>
                                                                <th>Enrollee Status</th>
                                                                <th colspan="3" class="text-center">Action</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
