<?php $__env->startSection('title'); ?>
    <?php echo e(__('Add-ons')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card border-primary mb-3">
            <div class="card-body">
                <h5 class="card-title"><?php echo e($package->name); ?></h5>
                <p class="card-text text-muted"><?php echo e($package->description); ?></p>
                <?php if($package->installed): ?>
                    <?php if($package->enabled): ?>
                        <?php if(isset($releases->{'add-ons'}->{$package->id})): ?>
                            <?php if(version_compare($releases->{'add-ons'}->{$package->id}->version, $package->version, '>')): ?>
                                <p class="text-warning mt-3">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <?php echo e(__('New version :v is available.', ['v' => $releases->{'add-ons'}->{$package->id}->version])); ?>

                                </p>
                            <?php endif; ?>
                        <?php endif; ?>
                        <div class="btn-group" role="group">
                            <button class="btn btn-success">
                                <?php echo e(__('Enabled v:v', ['v' => $package->version])); ?>

                            </button>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-success btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu">
                                    <form method="POST" action="<?php echo e(route('backend.addons.disable', $package->id)); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="dropdown-item">
                                            <?php echo e(__('Disable')); ?>

                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php if(isset($releases->{'add-ons'}->{$package->id})): ?>
                            <?php if(version_compare($releases->{'add-ons'}->{$package->id}->version, $package->version, '>')): ?>
                                <a href="<?php echo e(route('backend.addons.install.show', $package->id)); ?>" class="btn btn-primary"><?php echo e(__('Upgrade to v:v', ['v' => $releases->{'add-ons'}->{$package->id}->version])); ?></a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="btn-group" role="group">
                            <button class="btn btn-danger">
                                <?php echo e(__('Disabled')); ?>

                            </button>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-danger btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu">
                                    <form method="POST" action="<?php echo e(route('backend.addons.enable', $package->id)); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="dropdown-item">
                                            <?php echo e(__('Enable')); ?>

                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php if(isset($package->min_app_version) && version_compare(config('app.version'), $package->min_app_version, '<')): ?>
                            <p class="card-text text-danger mt-3"><?php echo e(__('Main app version should be at least :v1 (:v2 installed)', ['v1' => $package->min_app_version, 'v2' => config('app.version')])); ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="mt-3">
                        <a href="<?php echo e(route('backend.addons.changelog', $package->id)); ?>"><?php echo e(__('Changelog')); ?></a>
                    </div>
                <?php elseif($package->purchase_url): ?>
                    <a href="<?php echo e($package->purchase_url); ?>" class="btn btn-primary" target="_blank"><?php echo e(__('Purchase')); ?></a>
                    <a href="<?php echo e(route('backend.addons.install.show', $package->id)); ?>" class="btn btn-primary"><?php echo e(__('Install')); ?></a>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>