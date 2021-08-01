<?php $__env->startSection('title'); ?>
    <?php echo e(__('Widthdrawal')); ?> <?php echo e($withdrawal->id); ?> :: <?php echo e(__('Info')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <table class="table table-hover">
        <tbody>
        <tr>
            <td><?php echo e(__('ID')); ?></td>
            <td class="text-right"><?php echo e($withdrawal->id); ?></td>
        </tr>
        <tr>
            <td><?php echo e(__('External ID')); ?></td>
            <td class="text-right"><?php echo e($withdrawal->external_id); ?></td>
        </tr>
        <tr>
            <td><?php echo e(__('Amount')); ?></td>
            <td class="text-right"><?php echo e($withdrawal->amount); ?></td>
        </tr>
        <tr>
            <td><?php echo e(__('Payment amount')); ?></td>
            <td class="text-right"><?php echo e($withdrawal->payment_amount); ?></td>
        </tr>
        <tr>
            <td><?php echo e(__('Payment currency')); ?></td>
            <td class="text-right"><?php echo e($withdrawal->payment_currency); ?></td>
        </tr>
        <tr>
            <td><?php echo e(__('Method')); ?></td>
            <td class="text-right"><?php echo e($withdrawal->method->name); ?></td>
        </tr>
        <tr>
            <td><?php echo e(__('Status')); ?></td>
            <td class="text-right"><?php echo e($withdrawal->status_title); ?></td>
        </tr>
            <?php if($withdrawal->parameters): ?>
                <?php $__currentLoopData = $withdrawal->parameters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($withdrawal->method->keyed_parameters[$key]->name ?? $key); ?></td>
                        <td class="text-right">
                            <?php echo e(isset($withdrawal->method->keyed_parameters[$key]) && $withdrawal->method->keyed_parameters[$key]->type == 'switch' ? ($value ? __('Yes') : __('No')) : $value); ?>

                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <?php if($withdrawal->response): ?>
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
                                <?php $__currentLoopData = $withdrawal->response; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <pre><?php echo e(json_encode($item, JSON_PRETTY_PRINT)); ?></pre>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <tr>
                <td><?php echo e(__('Created')); ?></td>
                <td class="text-right"><?php echo e($withdrawal->created_at); ?></td>
            </tr>
            <tr>
                <td><?php echo e(__('Updated')); ?></td>
                <td class="text-right"><?php echo e($withdrawal->updated_at); ?></td>
            </tr>
        </tbody>
    </table>
    <?php if($withdrawal->is_created): ?>
        <h4 class="my-3"><?php echo e(__('Workflow actions')); ?></h4>

        <form class="float-left mr-2" method="POST" action="<?php echo e(route('backend.withdrawals.cancel', $withdrawal)); ?>">
            <?php echo csrf_field(); ?>
            <span data-balloon="<?php echo e(__('Cancel request and return funds to user account.')); ?>" data-balloon-pos="up">
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-times"></i>
                    <?php echo e(__('Cancel')); ?>

                </button>
            </span>
        </form>

        <?php if($withdrawal->method->code == 'coinpayments'): ?>
            <form class="float-left mr-2" method="POST" action="<?php echo e(route('backend.withdrawals.send', $withdrawal)); ?>">
                <?php echo csrf_field(); ?>
                <span data-balloon="<?php echo e(__('Approve request and send funds to user through API.')); ?>" data-balloon-pos="up">
                    <button type="submit" class="btn btn-outline-success">
                        <i class="fas fa-check"></i>
                        <?php echo e(__('Approve')); ?>

                    </button>
                </span>
            </form>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('backend.withdrawals.complete', $withdrawal)); ?>">
            <?php echo csrf_field(); ?>
            <span data-balloon="<?php echo e(__('Send funds manually and mark request as completed.')); ?>" data-balloon-pos="up">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check-double"></i>
                    <?php echo e(__('Complete')); ?>

                </button>
            </span>
        </form>

        <?php if($withdrawal->method->code == 'metamask' && !$withdrawal->external_id): ?>
            <div class="mt-3 mb-3">
                <div
                    id="component-container"
                    data-props="<?php echo e(json_encode(array_merge(['withdrawal' => $withdrawal], [
                        'config' => [
                            'deposit_address' => config('payments.ethereum.deposit_address'),
                            'deposit_contract' => config('payments.ethereum.deposit_contract'),
                            'deposit_contract_decimals' => config('payments.ethereum.deposit_contract_decimals'),
                        ],
                        ''
                    ]))); ?>"
                ></div>
            </div>
        <?php endif; ?>

        <?php if($withdrawal->method->code == 'bsc' && !$withdrawal->external_id): ?>
            <div class="mt-3 mb-3">
                <div
                    id="component-container"
                    data-props="<?php echo e(json_encode(array_merge(['withdrawal' => $withdrawal], [
                        'config' => [
                            'deposit_address' => config('payments.bsc.deposit_address'),
                            'deposit_contract' => config('payments.bsc.deposit_contract'),
                            'deposit_contract_decimals' => config('payments.bsc.deposit_contract_decimals'),
                        ],
                        ''
                    ]))); ?>"
                ></div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="mt-3">
        <a href="<?php echo e(route('backend.withdrawals.index', request()->query())); ?>"><i class="fas fa-long-arrow-alt-left"></i> <?php echo e(__('Back to all withdrawals')); ?></a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript" src="<?php echo e(mix('js/payments/admin/withdrawals/metamask.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>