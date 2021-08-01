<?php $__env->startSection('title'); ?>
    <?php echo e(__('Dashboard')); ?> :: <?php echo e(__('Accounts')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('backend.pages.dashboard.tabs', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="row text-center mt-3">
        <div class="col-sm-12 col-lg-4 mb-4">
            <div class="card border-primary">
                <div class="card-header border-primary bg-primary"><?php echo e(__('Average balance')); ?></div>
                <div class="card-body">
                    <h4 class="card-title m-0"><?php echo e($avg_balance); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-4 mb-4">
            <div class="card border-primary">
                <div class="card-header border-primary bg-primary"><?php echo e(__('Max balance')); ?></div>
                <div class="card-body">
                    <h4 class="card-title m-0"><?php echo e($max_balance); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-4 mb-4">
            <div class="card border-primary">
                <div class="card-header border-primary bg-primary"><?php echo e(__('Total balance')); ?></div>
                <div class="card-body">
                    <h4 class="card-title m-0"><?php echo e($total_balance); ?></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-12">
            <h2 class="text-center"><?php echo e(__('Transactions by type')); ?></h2>
            <pie-chart :data="<?php echo e(json_encode($transactions_by_type)); ?>" theme="<?php echo e($settings->theme); ?>" class="pie-chart"></pie-chart>
        </div>
    </div>
    <?php if(!$top_transactions->isEmpty()): ?>
        <div class="row mt-3">
            <div class="col-sm-12">
                <h2 class="text-center mb-4"><?php echo e(__('Top transactions')); ?></h2>
                <table class="table table-hover table-stackable">
                    <thead>
                    <tr>
                        <th><?php echo e(__('User')); ?></th>
                        <th><?php echo e(__('ID')); ?></th>
                        <th><?php echo e(__('Type')); ?></th>
                        <th class="text-right"><?php echo e(__('Amount')); ?></th>
                        <th class="text-right"><?php echo e(__('Created')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $top_transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td data-title="<?php echo e(__('User')); ?>">
                                <a href="<?php echo e(route('frontend.users.show', $transaction->account->user)); ?>">
                                    <?php echo e($transaction->account->user->name); ?>

                                </a>
                            </td>
                            <td data-title="<?php echo e(__('ID')); ?>"><?php echo e($transaction->transactionable_id); ?></td>
                            <td data-title="<?php echo e(__('Type')); ?>"><?php echo e($transaction->transactionable->title ?? __('Unknown')); ?></td>
                            <td data-title="<?php echo e(__('Amount')); ?>" class="text-right"><?php echo e($transaction->_amount); ?></td>
                            <td data-title="<?php echo e(__('Created')); ?>" class="text-right"><?php echo e($transaction->updated_at->diffForHumans()); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>