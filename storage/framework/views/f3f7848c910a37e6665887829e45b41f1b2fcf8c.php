

<?php $__env->startSection('title'); ?>
    <?php echo e(__('Deposit method')); ?> <?php echo e($props['method']->id); ?> :: <?php echo e(__('Edit')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div
        id="component-container"
        data-props="<?php echo e(json_encode(array_merge($props, [
            'input' => session()->getOldInput(),
            'errors' => $errors->get('*')
        ]), JSON_NUMERIC_CHECK)); ?>"
    ></div>
    <div class="mt-3">
        <a href="<?php echo e(route('backend.deposit-methods.index')); ?>"><i class="fas fa-long-arrow-alt-left"></i> <?php echo e(__('Back to all deposit methods')); ?></a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript" src="<?php echo e(mix('js/payments/admin/method-form.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>