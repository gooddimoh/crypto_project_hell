

<?php $__env->startSection('title'); ?>
    <?php echo e(__('Deposit')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div
        id="component-container"
        data-props="<?php echo e(json_encode(array_merge($props, [
            'input' => session()->getOldInput(),
            'errors' => $errors->get('*')
        ]), JSON_NUMERIC_CHECK)); ?>"
    ></div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(mix('css/payments/' . $settings->theme . '.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript" src="<?php echo e(mix('js/payments/deposits/create.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('frontend.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>