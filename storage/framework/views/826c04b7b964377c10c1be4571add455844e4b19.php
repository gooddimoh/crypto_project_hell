

<?php $__env->startSection('title'); ?>
    <?php echo e(__('Payment gateway')); ?> <?php echo e($payment_gateway->id); ?> :: <?php echo e(__('Edit')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <form method="POST" action="<?php echo e(route('backend.payment-gateways.update', $payment_gateway)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="form-group">
            <label><?php echo e(__('Code')); ?></label>
            <input class="form-control text-muted" value="<?php echo e($payment_gateway->code); ?>" readonly>
        </div>

        <div class="form-group">
            <label><?php echo e(__('Name')); ?></label>
            <input class="form-control" name="name" value="<?php echo e($payment_gateway->name); ?>">
        </div>

        <div class="form-group">
            <label><?php echo e(__('Currency')); ?></label>
            <input id="currency-input" class="form-control" name="currency" value="<?php echo e($payment_gateway->currency); ?>">
        </div>

        <div class="form-group">
            <label><?php echo e(__('Rate')); ?></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span id="rate-text" class="input-group-text"></span>
                </div>
                <input class="form-control" name="rate" value="<?php echo e($payment_gateway->rate); ?>">
                <div class="input-group-append">
                    <span class="input-group-text"><?php echo e(__('credits')); ?></span>
                </div>
            </div>
            <small>
                <?php echo e(__('Amount of credits per 1 unit of the reference currency.')); ?>

            </small>
        </div>

        <div class="form-group">
            <label><?php echo e(__('Created at')); ?></label>
            <input class="form-control text-muted" value="<?php echo e($payment_gateway->created_at); ?> (<?php echo e($payment_gateway->created_at->diffForHumans()); ?>)" readonly>
        </div>

        <div class="form-group">
            <label><?php echo e(__('Updated at')); ?></label>
            <input class="form-control text-muted" value="<?php echo e($payment_gateway->updated_at); ?> (<?php echo e($payment_gateway->updated_at->diffForHumans()); ?>)" readonly>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i>
            <?php echo e(__('Save')); ?>

        </button>
    </form>
    <div class="mt-3">
        <a href="<?php echo e(route('backend.payment-gateways.index')); ?>"><i class="fas fa-long-arrow-alt-left"></i> <?php echo e(__('Back to all payment gateways')); ?></a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        var currency = '<?php echo e($payment_gateway->currency); ?>';
        var currencyInput = document.getElementById('currency-input');
        var rateText = document.getElementById('rate-text');

        setRateText(currency);

        currencyInput.addEventListener('input', function (e) {
            setRateText(e.target.value)
        });

        function setRateText (currency) {
            rateText.innerHTML = '1 ' + currency + ' = ';
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>