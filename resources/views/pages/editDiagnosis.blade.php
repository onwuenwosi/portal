@extends('layouts.app')


@section('title')
    Tariff (Diagnosis)
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
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Update Diagnosis</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('tariff.update', $data->id) }}" method="post">
                                @method('PATCH')
                                @csrf
                                <div class="form-group">
                                    <label for="procedure">Diagnosis Name</label>
                                    <input type="text" id="diagnosis" class="form-control" name="procedure"
                                        value="{{ $data->diagnosis }}">
                                    @error('diagnosis')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <button class="btn btn-success">Update Tarriff</button>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-8">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Item ID</th>
                                <th>Diagnosis</th>
                                <th colspan="2" class="text-center">Action</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($credentials as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->procedure }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>NGN {{ $item->price }}</td>
                                    <td>
                                        <form action="{{ route('tariff.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this Procedure?');">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    <td>
                                        <a href="{{ route('tariff.edit', $item->id) }}" class="btn btn-primary">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <div class="text-danger m-auto"> No record found </div>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6">
                                    <div>
                                        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css"
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
            </div>
        </section>
    </div>
@endsection
