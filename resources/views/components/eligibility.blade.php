<div class="modal fade" id="check" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Search for Enrollee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex gap-3">
                            <button class="btn btn-secondary" id="searchPrincipal">Search for Principal</button>
                            <button class="btn btn-secondary" id="searchDependent">Search for Dependent</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="principal">
                            <form action="{{ route('search.principal') }}" method="GET">
                                <div class="form-group d-flex">
                                    <input type="text" name="query" id="query" value="{{ request('query') }}"
                                        class="form-control" placeholder="Enter principal's name or ID..." required>
                                    <button class="btn btn-primary">Search</button>
                                </div>
                            </form>
                        </div>
                        <div id="dependent" style="display:none;">
                            <form action="{{ route('search.dependent') }}" method="GET">
                                <div class="form-group  d-flex">
                                    <input type="text" name="query" id="query" value="{{ request('query') }}"
                                        class="form-control" placeholder="Search ...">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Get the buttons and forms
    const principalBtn = document.getElementById('searchPrincipal');
    const dependentBtn = document.getElementById('searchDependent');
    const principalForm = document.getElementById('principal');
    const dependentForm = document.getElementById('dependent');

    // Function to handle button color and active state
    function activateButton(button) {
        // Reset both buttons to secondary
        principalBtn.classList.remove('btn-primary');
        principalBtn.classList.add('btn-secondary');
        dependentBtn.classList.remove('btn-primary');
        dependentBtn.classList.add('btn-secondary');

        // Set the clicked button to primary
        button.classList.remove('btn-secondary');
        button.classList.add('btn-primary');
    }

    // Event listeners for toggling
    principalBtn.addEventListener('click', () => {
        activateButton(principalBtn);
        principalForm.style.display = 'block';
        dependentForm.style.display = 'none';
    });

    dependentBtn.addEventListener('click', () => {
        activateButton(dependentBtn);
        principalForm.style.display = 'none';
        dependentForm.style.display = 'block';
    });
</script>
