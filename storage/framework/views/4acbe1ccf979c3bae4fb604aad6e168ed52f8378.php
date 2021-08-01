

<?php $__env->startSection('title'); ?>
    <?php echo e(__('Withdrawal methods')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row mb-3">
        <div class="col">
            <a href="<?php echo e(route('backend.withdrawal-methods.create')); ?>" class="btn btn-primary">
                <?php echo e(__('Create withdrawal method')); ?>

            </a>
        </div>
    </div>
    <?php if($withdrawal_methods->isEmpty()): ?>
        <div class="alert alert-info" role="alert">
            <?php echo e(__('No withdrawal methods found.')); ?>

        </div>
    <?php else: ?>
        <table class="table table-hover table-stackable">
            <thead>
            <tr>
                <th><?php echo e(__('ID')); ?></th>
                <th><?php echo e(__('Code')); ?></th>
                <th><?php echo e(__('Name')); ?></th>
                <th><?php echo e(__('Gateway')); ?></th>
                <th><?php echo e(__('Status')); ?></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $withdrawal_methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawal_method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td data-title="<?php echo e(__('ID')); ?>"><?php echo e($withdrawal_method->id); ?></td>
                    <td data-title="<?php echo e(__('Code')); ?>"><?php echo e($withdrawal_method->code); ?></td>
                    <td data-title="<?php echo e(__('Name')); ?>"><?php echo e($withdrawal_method->name); ?></td>
                    <td data-title="<?php echo e(__('Gateway')); ?>"><?php echo e($withdrawal_method->gateway->name ?? ''); ?></td>
                    <td data-title="<?php echo e(__('Status')); ?>"><?php echo e($withdrawal_method->status_title); ?></td>
                    <td class="text-right">
                        <div class="btn-group" role="group" aria-label="<?php echo e(__('Edit')); ?>">
                            <a href="<?php echo e(route('backend.withdrawal-methods.edit', array_merge(['withdrawal-method' => $withdrawal_method], request()->query()))); ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit fa-sm"></i>
                                <?php echo e(__('Edit')); ?>

                            </a>
                            <div class="btn-group" role="group">
                                <button id="users-action-button" type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu" aria-labelledby="users-action-button">
                                    <a class="dropdown-item" href="<?php echo e(route('backend.withdrawal-methods.edit', array_merge(['withdrawal-method' => $withdrawal_method], request()->query()))); ?>">
                                        <i class="fas fa-edit fa-sm"></i>
                                        <?php echo e(__('Edit')); ?>

                                    </a>
                                    <a class="dropdown-item" href="<?php echo e(route('backend.withdrawal-methods.delete', array_merge(['withdrawal-method' => $withdrawal_method], request()->query()))); ?>">
                                        <i class="fas fa-trash fa-sm"></i>
                                        <?php echo e(__('Delete')); ?>

                                    </a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>