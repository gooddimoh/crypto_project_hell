<?php $__env->startSection('title'); ?>
    <?php echo e(__('Deposit')); ?> <?php echo e($deposit->id); ?> :: <?php echo e(__('Info')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <table class="table table-hover">
        <tbody>
            <tr>
                <td><?php echo e(__('ID')); ?></td>
                <td class="text-right"><?php echo e($deposit->id); ?></td>
            </tr>
            <tr>
                <td><?php echo e(__('External ID')); ?></td>
                <td class="text-right"><?php echo e($deposit->external_id); ?></td>
            </tr>
            <tr>
                <td><?php echo e(__('Amount')); ?></td>
                <td class="text-right"><?php echo e($deposit->amount); ?></td>
            </tr>
            <tr>
                <td><?php echo e(__('Payment amount')); ?></td>
                <td class="text-right"><?php echo e($deposit->payment_amount); ?></td>
            </tr>
            <tr>
                <td><?php echo e(__('Payment currency')); ?></td>
                <td class="text-right"><?php echo e($deposit->payment_currency); ?></td>
            </tr>
            <tr>
                <td><?php echo e(__('Method')); ?></td>
                <td class="text-right"><?php echo e($deposit->method->name); ?></td>
            </tr>
            <tr>
                <td><?php echo e(__('Status')); ?></td>
                <td class="text-right"><?php echo e($deposit->status_title); ?></td>
            </tr>
            <?php if($deposit->parameters): ?>
                <?php $__currentLoopData = $deposit->parameters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($deposit->method->keyed_parameters[$key]->name ?? $key); ?></td>
                        <td class="text-right">
                            <?php echo e(isset($deposit->method->keyed_parameters[$key]) && $deposit->method->keyed_parameters[$key]->type == 'switch' ? ($value ? __('Yes') : __('No')) : $value); ?>

                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <?php if($deposit->response): ?>
                <tr>
                    <td><?php echo e(__('API response')); ?></td>
                    <td class="text-right">
                        <button data-toggle="modal" data-target="#response-modal" class="btn btn-link">
                            <?php echo e(__('View')); ?>

                        </button>
                    </td>
                </tr>
                <div class="modal fade" id="response-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('API response')); ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <?php $__currentLoopData = $deposit->response; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <pre><?php echo e(json_encode($item, JSON_PRETTY_PRINT)); ?></pre>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <tr>
                <td><?php echo e(__('Created')); ?></td>
                <td class="text-right"><?php echo e($deposit->created_at); ?></td>
            </tr>
            <tr>
                <td><?php echo e(__('Updated')); ?></td>
                <td class="text-right"><?php echo e($deposit->updated_at); ?></td>
            </tr>
        </tbody>
    </table>
    <?php if($deposit->is_created && !$deposit->method->gateway): ?>
        <h4 class="my-3"><?php echo e(__('Workflow actions')); ?></h4>

        <form class="float-left mr-2" method="POST" action="<?php echo e(route('backend.deposits.cancel', $deposit)); ?>">
            <?php echo csrf_field(); ?>
            <span data-balloon="<?php echo e(__('Cancel deposit request.')); ?>" data-balloon-pos="up">
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-times"></i>
                    <?php echo e(__('Cancel')); ?>

                </button>
            </span>
        </form>

        <form class="mr-2" method="POST" action="<?php echo e(route('backend.deposits.complete', $deposit)); ?>">
            <?php echo csrf_field(); ?>
            <span data-balloon="<?php echo e(__('Approve deposit request and add funds to user account.')); ?>" data-balloon-pos="up">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check-double"></i>
                    <?php echo e(__('Complete')); ?>

                </button>
            </span>
        </form>
    <?php endif; ?>
    <div class="mt-3">
        <a href="<?php echo e(route('backend.deposits.index', request()->query())); ?>"><i class="fas fa-long-arrow-alt-left"></i> <?php echo e(__('Back to all deposits')); ?></a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>