@extends('layouts.app')

@section('title')
    Approval Request
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
                <div class="card mt-2">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Diagnosis</th>
                                    <th>Procedure</th>
                                    <th>Comment</th>
                                    <th>Remark</th>
                                    <th colspan="2" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($credentials as $item)
                                    <tr>
                                        <td>{{ $item->Diagnosis }}</td>
                                        <td>{{ $item->Procedure }}</td>
                                        <td>{{ $item->comment }}</td>
                                        <td>{{ $item->Remark }}</td>
                                        <td>
                                            <button class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#modalId{{ $item->id }}">
                                                View
                                            </button>
                                        </td>
                                        @if (auth()->user()->role === 'User')
                                            <td>
                                                <form action="{{ route('claims.store') }}" method="POST">
                                                    @csrf
                                                    <div hidden>
                                                        <input type="text" value="{{ $item->batch_id }}"
                                                            class="form-control" name="batch_id">
                                                        <input type="text" value="{{ $item->policynumber }}"
                                                            class="form-control" name="policynumber">
                                                        <input type="text" value="{{ $item->user_id }}"
                                                            class="form-control" name="user_id">
                                                        <input type="text" value="{{ $item->request_id }}"
                                                            class="form-control" name="request_id">
                                                        <input type="text" value="{{ $item->Remark }}"
                                                            class="form-control" name="Remark">
                                                    </div>
                                                    <button class="btn btn-danger" type="submit">Process Claim</button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal -->
    @foreach ($credentials as $item)
        <div class="modal fade" id="modalId{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog  modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId{{ $item->id }}"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    @if (auth()->user()->role === 'Admin')
                        <div class="modal-body">
                            <div><b>Diagnosis: </b><span
                                    id="modalDiagnosis{{ $item->id }}">{{ $item->Diagnosis }}</span></div>
                            <div><b>Comment: </b><span id="modalComment{{ $item->id }}">{{ $item->comment }}</span>
                            </div>
                            @if ($item->Remark === 'Approved')
                                <div><b>Code: </b><span id="modalcode{{ $item->id }}">{{ $item->code }}</span>
                                </div>
                            @else
                                <div><b>Code: </b>
                                </div>
                            @endif
                            <form action="{{ route('approval', $item->id) }}" method="post">
                                @method('PATCH')
                                @csrf
                                <table class="table table-bordered mt-3">
                                    <thead>
                                        <tr>
                                            <th>Procedure</th>
                                            <th>Qty</th>
                                            <th>Unit Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td id="modalProcedure{{ $item->id }}">{{ $item->Procedure }}</td>
                                            <td>
                                                <input type="number" id="modalQty{{ $item->id }}"
                                                    class="form-control-plaintext" name="Qty"
                                                    value="{{ $item->Qty }}">
                                            </td>
                                            <td><input type="text" class="form-control-plaintext"
                                                    id="modalUnitPrice{{ $item->id }}" name="UnitPrice"
                                                    id="UnitPrice{{ $item->id }}" value="{{ $item->UnitPrice }}"
                                                    readonly></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <div>
                                    <div class="form-group">
                                        <label for="HMOcomment">Comment</label>
                                        <textarea name="HMO_comment" id="HMOcomment{{ $item->id }}" class="form-control" placeholder="HMO comment">{{ $item->HMO_comment }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="Modalremark">Remark</label>
                                        <select name="Remark" id="Modalremark{{ $item->id }}" class="form-control">
                                            <option value="" {{ $item->Remark == '' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="Declined" {{ $item->Remark == 'Declined' ? 'selected' : '' }}>
                                                Declined</option>
                                            <option value="Approved" {{ $item->Remark == 'Approved' ? 'selected' : '' }}>
                                                Approved</option>

                                        </select>
                                    </div>
                                </div>
                                <input type="text" name="approvedBy" value="{{ auth()->user()->name }}" hidden>
                                <button class="btn btn-primary" id="update_request{{ $item->id }}"
                                    type="submit">Submit</button>
                            </form>
                        </div>
                    @else
                        <div class="p-3">
                            <div><b>Diagnosis: </b><span
                                    id="modalDiagnosis{{ $item->id }}">{{ $item->Diagnosis }}</span></div>
                            <div><b>Comment: </b><span id="modalComment{{ $item->id }}">{{ $item->comment }}</span>
                                <div><b>Remark: </b><span id="modalComment{{ $item->id }}">{{ $item->Remark }}</span>
                                </div>
                                @if ($item->Remark === 'Approved')
                                    <div><b>Code: </b><span id="modalcode{{ $item->id }}">{{ $item->code }}</span>
                                    </div>
                                @else
                                    <div><b>Code: </b>
                                    </div>
                                @endif
                                <table class="table table-bordered mt-3">
                                    <thead>
                                        <tr>
                                            <th>Procedure</th>
                                            <th>Qty</th>
                                            <th>Unit Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td id="modalProcedure{{ $item->id }}">{{ $item->Procedure }}</td>
                                            <td id="modalQty{{ $item->id }}">{{ $item->Qty }} </td>
                                            <td id="modalUnitPrice{{ $item->id }}">{{ $item->UnitPrice }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <div>
                                    <div class="form-group">
                                        <label for="HMOcomment">HMO Comment</label>
                                        <textarea name="HMO_comment" id="HMOcomment{{ $item->id }}" class="form-control-plaintext" readonly>{{ $item->HMO_comment }}</textarea>
                                    </div>
                                </div>
                            </div>
                    @endif
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
@section('script')
    <script>
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', () => {
                const button = form.querySelector('button[type="submit"]');
                button.disabled = true;
                button.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Processing...';
            });
        });
    </script>
@endsection
