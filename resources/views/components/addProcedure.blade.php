<div class="modal fade" id="addProcedure" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Procedure</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form action="{{ route('tariff.store') }}" method="post">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="procedure">Procedure Name</label>
                            <input type="text" id="procedure" class="form-control" name="procedure"
                                placeholder="Enter Procedure name">
                            @error('procedure')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Procedure Description</label>
                            <select name="description" id="description" class="form-control">
                                <option value="">Select from the list</option>
                                <option value="Tablet">Tablet</option>
                                <option value="Capulse">Capulse</option>
                                <option value="Syrup">Syrup</option>
                                <option value="Suspension">Suspension</option>
                                <option value="cream">cream</option>
                                <option value="Consumable">Consumable</option>
                                <option value="Lab">Lab</option>
                                <option value="Radiology">Radiology</option>
                                <option value="Theatre">Theatre</option>
                                <option value="Injectable">Injectable</option>
                                <option value="emergency">Emergency</option>
                                <option value="OPD">OPD</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="price">Price (NGN)</label>
                            <input type="number" class="form-control" name="price" placeholder="0.0">
                            @error('price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-success" type="submit" >Create Tarriff</button>
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
