<?php $__env->startSection('title'); ?>
    <?php echo e(__('Reset password')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-primary">
                <div class="card-header bg-primary"><?php echo e(__('Reset Password')); ?></div>

                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('password.email')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right"><?php echo e(__('E-Mail Address')); ?></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" name="email" value="<?php echo e(old('email')); ?>" required>

                                <?php if($errors->has('email')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if(config('settings.recaptcha.public_key')): ?>
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="g-recaptcha" data-sitekey="<?php echo e(config('settings.recaptcha.public_key')); ?>" data-theme="<?php echo e(config('settings.theme')=='light-blue' ? 'light' : 'dark'); ?>"></div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <?php echo e(__('Send Password Reset Link')); ?>

                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php if(config('settings.recaptcha.public_key')): ?>
    <?php $__env->startPush('scripts'); ?>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>

<?php echo $__env->make('frontend.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>