<div class="modal fade" id="addDiagnosis" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Diagnosis</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form action="{{ route('dxAdd') }}" method="post">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="diagnosis">Diagnosis Name</label>
                            <input type="text" id="diagnosis" class="form-control" name="diagnosis"
                                placeholder="Enter diagnosis name">
                            @error('diagnosis')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-success" type="submit">Create Tarriff</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
