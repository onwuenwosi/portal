<!-- Modal -->
<div class="modal fade" id="encounterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

            </div>
            <div class="modal-body">
                <form action="">
                    @csrf
                    <input type="search" id="search" name="search" class="form-control"
                        placeholder="Search with Enrollee Number">
                    <button class="btn btn-primary mt-2 float-end">Search</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="{{ route('request.create') }}" class="btn btn-danger">View</a>
            </div>
        </div>
    </div>
</div>
