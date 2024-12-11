<div class="modal fade" id="addProcedure" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Procedure</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form action="<?php echo e(route('tariff.store')); ?>" method="post">
                        <?php echo method_field('POST'); ?>
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="procedure">Procedure Name</label>
                            <input type="text" id="procedure" class="form-control" name="procedure"
                                placeholder="Enter Procedure name">
                            <?php $__errorArgs = ['procedure'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                            <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-success">Create Tarriff</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\LARAVEL\myPortal\resources\views/components/addProcedure.blade.php ENDPATH**/ ?>