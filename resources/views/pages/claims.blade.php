@extends('layouts.app')

@section('title')
    Cliams
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content">
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
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Enrollee Number</th>
                                    <th>Name</th>
                                    <th>Submited By</th>
                                    <th>Status</th>
                                    <th>Date Submitted</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($principal as $item)
                                    <tr>
                                        <td>{{ $item->policynumber }}</td>
                                        <td>{{ $item->surname }}, {{ $item->othername }}</td>
                                        <td>{{ $item->user }}</td>
                                        <td>{{ $item->stat }}</td>
                                        <td>{{ $item->date }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal"
                                                data-bs-target="#modalId{{ $item->claim_id }}">
                                                View
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                @foreach ($dependent as $item)
                                    <tr>
                                        <td>{{ $item->batch_id }}</td>
                                        <td>{{ $item->policynumber }}</td>
                                        <td>{{ $item->surname }}, {{ $item->othername }}</td>
                                        <td>{{ $item->user }}</td>
                                        <td>{{ $item->stat }}</td>
                                        <td>{{ $item->Total }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal"
                                                data-bs-target="#modalId{{ $item->claim_id }}">
                                                View
                                            </button>
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
    @foreach ($principal as $item)
        <div class="modal fade" id="modalId{{ $item->claim_id }}" tabindex="-1" role="dialog"
            aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId{{ $item->claim_id }}">
                            {{ $item->surname }}, {{ $item->othername }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Drug</th>
                                        <th>Diagnosis</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $item->Procedure }}</td>
                                        <td>{{ $item->Diagnosis }}</td>
                                        <td>{{ $item->Qty }}</td>
                                        <td>{{ $item->Total }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if (auth()->user()->role === 'Admin')
                        <div class="modal-footer">
                            <form action="{{ route('claim.update', $item->claim_id) }}" id="formData{{ $item->id }}"
                                method="post">
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class=" d-flex">
                                        <div class="m-3">
                                            <label for="Approved">Approved</label>
                                            <input type="radio" name="status" id="Approved" value="Approved">
                                        </div>
                                        <div class="m-3">
                                            <label for="Declined">Declined</label>
                                            <input type="radio" name="status" id="Declined" value="Declined">
                                        </div>
                                        <button type="submit" id="submit" class="btn btn-primary submit">Save
                                            Claim</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
    @foreach ($dependent as $item)
        <div class="modal fade" id="modalId{{ $item->claim_id }}" tabindex="-1" role="dialog"
            aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId{{ $item->claim_id }}">
                            {{ $item->surname }}, {{ $item->othername }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Drug</th>
                                        <th>Diagnosis</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $item->Procedure }}</td>
                                        <td>{{ $item->Diagnosis }}</td>
                                        <td>{{ $item->Qty }}</td>
                                        <td>{{ $item->Total }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if (auth()->user()->role === 'Admin')
                        <div class="modal-footer">
                            <form action="{{ route('claim.update', $item->claim_id) }}" id="formData{{ $item->id }}"
                                method="post">
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class=" d-flex">
                                        <div class="m-3">
                                            <label for="Approved">Approved</label>
                                            <input type="radio" name="status" id="Approved" value="Approved">
                                        </div>
                                        <div class="m-3">
                                            <label for="Declined">Declined</label>
                                            <input type="radio" name="status" id="Declined" value="Declined">
                                        </div>
                                        <button type="submit" id="submit" class="btn btn-primary submit">Save
                                            Claim</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@endsection
