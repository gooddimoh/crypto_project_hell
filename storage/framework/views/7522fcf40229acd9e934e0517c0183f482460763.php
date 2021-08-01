<div class="card border-primary">
    <div class="card-header border-primary">
        <h5 class="mb-0">
            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-game-dice-3d" aria-expanded="true">
                <?php echo e(__('Game: :game', ['game' => __('Dice 3D')])); ?>

            </button>
        </h5>
    </div>
    <div id="tab-game-dice-3d" class="collapse">
        <div class="card-body">
            <div class="form-group">
                <label><?php echo e(__('Categories')); ?></label>
                <input type="text" name="GAME_DICE_3D_CATEGORIES" class="form-control" value="<?php echo e(config('game-dice-3d.categories')); ?>">
                <small><?php echo e(__('Comma-delimited list')); ?></small>
            </div>
            <file-upload
                label="<?php echo e(__('Banner')); ?>"
                path="<?php echo e(config('game-dice-3d.banner')); ?>"
                name="GAME_DICE_3D_BANNER"
                file-name="dice-3d"
                folder="home"
            ></file-upload>
            <div class="form-group">
                <label><?php echo e(__('Min bet')); ?></label>
                <input type="number" name="GAME_DICE_3D_MIN_BET" class="form-control" value="<?php echo e(config('game-dice-3d.min_bet')); ?>">
            </div>
            <div class="form-group">
                <label><?php echo e(__('Max bet')); ?></label>
                <input type="number" name="GAME_DICE_3D_MAX_BET" class="form-control" value="<?php echo e(config('game-dice-3d.max_bet')); ?>">
            </div>
            <div class="form-group">
                <label><?php echo e(__('Bet increment / decrement amount')); ?></label>
                <input type="number" name="GAME_DICE_3D_BET_CHANGE_AMOUNT" class="form-control" value="<?php echo e(config('game-dice-3d.bet_change_amount')); ?>">
            </div>
            <div class="form-group">
                <label><?php echo e(__('Default bet amount')); ?></label>
                <input type="number" name="GAME_DICE_3D_DEFAULT_BET_AMOUNT" class="form-control" value="<?php echo e(config('game-dice-3d.default_bet_amount')); ?>">
            </div>
            <div class="form-group">
                <label><?php echo e(__('House edge')); ?></label>
                <div class="input-group">
                    <input type="number" name="GAME_DICE_3D_HOUSE_EDGE" class="form-control" value="<?php echo e(config('game-dice-3d.house_edge')); ?>">
                    <div class="input-group-append">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label><?php echo e(__('Dice')); ?></label>
                <select multiple name="GAME_DICE_3D_DICE[]" class="form-control">
                    <?php $__currentLoopData = array_keys(config('game-dice-3d.dice_types')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $die): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($die); ?>" <?php echo e(in_array($die, config('game-dice-3d.dice')) ? 'selected' : ''); ?>>
                            <?php echo e(__(ucfirst($die))); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <small>
                    <?php echo e(__('Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple items.')); ?>

                </small>
            </div>
        </div>
    </div>
</div>
