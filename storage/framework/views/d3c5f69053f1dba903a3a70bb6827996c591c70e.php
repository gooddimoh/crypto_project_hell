

<?php $__env->startSection('title'); ?>
    <?php echo e(__('Withdrawals')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-6 mb-3">
            <div class="btn-group" role="group" aria-label="<?php echo e(__('All statuses')); ?>">
                <?php if(Request::has('status')): ?>
                    <?php $__currentLoopData = \Packages\Payments\Models\Withdrawal::statuses(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(Request::get('status') == $status): ?>
                            <a href="<?php echo e(route('backend.withdrawals.index', array_merge(request()->query(), ['status' => $status]))); ?>" class="btn btn-primary"><?php echo e($title); ?></a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <a href="<?php echo e(route('backend.withdrawals.index', request()->query())); ?>" class="btn btn-primary"><?php echo e(__('All statuses')); ?></a>
                <?php endif; ?>
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?php echo e(route('backend.withdrawals.index', array_merge(request()->query(), ['status' => NULL]))); ?>"><?php echo e(__('All statuses')); ?></a>
                    <div class="dropdown-divider"></div>
                    <?php $__currentLoopData = \Packages\Payments\Models\Withdrawal::statuses(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('backend.withdrawals.index', array_merge(request()->query(), ['status' => $status]))); ?>" class="dropdown-item"><?php echo e($title); ?></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-3 offset-lg-3 mb-3">
            <?php $__env->startComponent('components.tables.search', ['route' => 'backend.withdrawals.index', 'search' => $search]); ?>
            <?php echo $__env->renderComponent(); ?>
        </div>
    </div>
    <?php if($withdrawals->isEmpty()): ?>
        <div class="alert alert-info" role="alert">
            <?php echo e(__('No withdrawals found.')); ?>

        </div>
    <?php else: ?>
        <table class="table table-hover table-stackable">
            <thead>
            <tr>
                <?php $__env->startComponent('components.tables.sortable-column', ['id' => 'id', 'sort' => $sort, 'order' => $order]); ?>
                    <?php echo e(__('ID')); ?>

                <?php echo $__env->renderComponent(); ?>
                <th>
                    <a href="#"><?php echo e(__('User')); ?></a>
                </th>
                <?php $__env->startComponent('components.tables.sortable-column', ['id' => 'method', 'sort' => $sort, 'order' => $order]); ?>
                    <?php echo e(__('Method')); ?>

                <?php echo $__env->renderComponent(); ?>
                <?php $__env->startComponent('components.tables.sortable-column', ['id' => 'amount', 'sort' => $sort, 'order' => $order, 'class' => 'text-right']); ?>
                    <?php echo e(__('Amount')); ?>

                <?php echo $__env->renderComponent(); ?>
                <?php $__env->startComponent('components.tables.sortable-column', ['id' => 'payment_amount', 'sort' => $sort, 'order' => $order, 'class' => 'text-right']); ?>
                    <?php echo e(__('Payment amount')); ?>

                <?php echo $__env->renderComponent(); ?>
                <?php $__env->startComponent('components.tables.sortable-column', ['id' => 'status', 'sort' => $sort, 'order' => $order, 'class' => 'text-right']); ?>
                    <?php echo e(__('Status')); ?>

                <?php echo $__env->renderComponent(); ?>
                <?php $__env->startComponent('components.tables.sortable-column', ['id' => 'created', 'sort' => $sort, 'order' => $order, 'class' => 'text-right']); ?>
                    <?php echo e(__('Created')); ?>

                <?php echo $__env->renderComponent(); ?>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $withdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td data-title="<?php echo e(__('ID')); ?>"><?php echo e($withdrawal->id); ?></td>
                    <td data-title="<?php echo e(__('User')); ?>">
                        <a href="<?php echo e(route('backend.users.edit', $withdrawal->account->user)); ?>">
                            <?php echo e($withdrawal->account->user->name); ?>

                        </a>
                        <?php if($withdrawal->account->user->role == App\Models\User::ROLE_ADMIN): ?>
                            <span class="badge badge-danger"><?php echo e(__('app.user_role_'.$withdrawal->account->user->role)); ?></span>
                        <?php endif; ?>
                    </td>
                    <td data-title="<?php echo e(__('Method')); ?>">
                        <?php echo e($withdrawal->method->name); ?>

                    </td>
                    <td data-title="<?php echo e(__('Amount')); ?>" class="text-right">
                        <?php echo e($withdrawal->_amount); ?>

                    </td>
                    <td data-title="<?php echo e(__('Payment amount')); ?>" class="text-right">
                        <?php echo e($withdrawal->_payment_amount); ?> <?php echo e($withdrawal->_payment_currency); ?>

                    </td>
                    <td data-title="<?php echo e(__('Status')); ?>" class="text-right <?php echo e($withdrawal->is_completed ? 'text-success' : ($withdrawal->is_cancelled ? 'text-danger' : '')); ?>">
                        <?php echo e($withdrawal->status_title); ?>

                    </td>
                    <td data-title="<?php echo e(__('Created')); ?>" class="text-right">
                        <?php echo e($withdrawal->created_at->diffForHumans()); ?>

                        <span data-balloon="<?php echo e($withdrawal->created_at); ?>" data-balloon-pos="up">
                            <i class="far fa-clock" ></i>
                        </span>
                    </td>
                    <td class="text-right">
                        <div class="btn-group" role="group" aria-label="<?php echo e(__('View')); ?>">
                            <a href="<?php echo e(route('backend.withdrawals.show', array_merge(['withdrawal' => $withdrawal], request()->query()))); ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye fa-sm"></i>
                                <?php echo e(__('View')); ?>

                            </a>
                            <div class="btn-group" role="group">
                                <button id="users-action-button" type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu" aria-labelledby="users-action-button">
                                    <a class="dropdown-item" href="<?php echo e(route('backend.withdrawals.show', array_merge(['withdrawal' => $withdrawal], request()->query()))); ?>">
                                        <i class="fas fa-eye fa-sm"></i>
                                        <?php echo e(__('View')); ?>

                                    </a>
                                    <?php if($withdrawal->is_created): ?>
                                        <div class="dropdown-divider"></div>
                                        <form method="POST" action="<?php echo e(route('backend.withdrawals.cancel', $withdrawal)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-times"></i>
                                                <?php echo e(__('Cancel')); ?>

                                            </button>
                                        </form>
                                        <?php if($withdrawal->method->code == 'coinpayments'): ?>
                                            <form method="POST" action="<?php echo e(route('backend.withdrawals.send', $withdrawal)); ?>">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fas fa-check"></i>
                                                    <?php echo e(__('Approve')); ?>

                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        <form method="POST" action="<?php echo e(route('backend.withdrawals.complete', $withdrawal)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-check-double"></i>
                                                <?php echo e(__('Complete')); ?>

                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    <?php if($withdrawal->external_id): ?>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="<?php echo e(route('backend.withdrawals.transaction', array_merge(['withdrawals' => $withdrawal], request()->query()))); ?>">
                                            <i class="fa fa-exchange-alt"></i>
                                            <?php echo e(__('Transaction')); ?>

                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            <?php echo e($withdrawals->appends(request()->query())->links()); ?>

        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>