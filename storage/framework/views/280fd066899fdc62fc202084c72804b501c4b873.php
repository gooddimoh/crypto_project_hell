

<?php $__env->startSection('title'); ?>
    <?php echo e(__('Payment gateways')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if($payment_gateways->isEmpty()): ?>
        <div class="alert alert-info" role="alert">
            <?php echo e(__('No payment gateways found.')); ?>

        </div>
    <?php else: ?>
        <table class="table table-hover table-stackable">
            <thead>
            <tr>
                <th><?php echo e(__('ID')); ?></th>
                <th><?php echo e(__('Code')); ?></th>
                <th><?php echo e(__('Name')); ?></th>
                <th><?php echo e(__('Currency')); ?></th>
                <th><?php echo e(__('Rate')); ?></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $payment_gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment_gateway): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td data-title="<?php echo e(__('ID')); ?>"><?php echo e($payment_gateway->id); ?></td>
                    <td data-title="<?php echo e(__('Code')); ?>"><?php echo e($payment_gateway->code); ?></td>
                    <td data-title="<?php echo e(__('Name')); ?>"><?php echo e($payment_gateway->name); ?></td>
                    <td data-title="<?php echo e(__('Currency')); ?>"><?php echo e($payment_gateway->currency); ?></td>
                    <td data-title="<?php echo e(__('Rate')); ?>"><?php echo e($payment_gateway->rate); ?></td>
                    <td class="text-right">
                        <div class="btn-group" role="group" aria-label="<?php echo e(__('Edit')); ?>">
                            <a href="<?php echo e(route('backend.payment-gateways.edit', array_merge(['payment-gateways' => $payment_gateway], request()->query()))); ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit fa-sm"></i>
                                <?php echo e(__('Edit')); ?>

                            </a>
                            <div class="btn-group" role="group">
                                <button id="users-action-button" type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu" aria-labelledby="users-action-button">
                                    <?php if($payment_gateway->code == 'coinpayments'): ?>
                                        <a class="dropdown-item" href="<?php echo e(route('backend.payment-gateways.info', array_merge(['payment-gateways' => $payment_gateway], request()->query()))); ?>">
                                            <i class="fas fa-info fa-sm"></i>
                                            <?php echo e(__('Info')); ?>

                                        </a>
                                        <a class="dropdown-item" href="<?php echo e(route('backend.payment-gateways.balance', array_merge(['payment-gateways' => $payment_gateway], request()->query()))); ?>">
                                            <i class="fas fa-wallet fa-sm"></i>
                                            <?php echo e(__('Balance')); ?>

                                        </a>
                                    <?php endif; ?>
                                    <a class="dropdown-item" href="<?php echo e(route('backend.payment-gateways.edit', array_merge(['payment-gateways' => $payment_gateway], request()->query()))); ?>">
                                        <i class="fas fa-edit fa-sm"></i>
                                        <?php echo e(__('Edit')); ?>

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