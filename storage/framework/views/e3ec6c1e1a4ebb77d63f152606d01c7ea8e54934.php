<div class="card border-primary">
    <div class="card-header border-primary">
        <h5 class="mb-0">
            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-game-american-roulette" aria-expanded="true">
                <?php echo e(__('Game: :game', ['game' => __('American Roulette')])); ?>

            </button>
        </h5>
    </div>
    <div id="tab-game-american-roulette" class="collapse">
        <div class="card-body">
            <div class="form-group">
                <label><?php echo e(__('Categories')); ?></label>
                <input type="text" name="GAME_AMERICAN_ROULETTE_CATEGORIES" class="form-control" value="<?php echo e(config('game-american-roulette.categories')); ?>">
                <small><?php echo e(__('Comma-delimited list')); ?></small>
            </div>
            <file-upload
                label="<?php echo e(__('Banner')); ?>"
                path="<?php echo e(config('game-american-roulette.banner')); ?>"
                name="GAME_AMERICAN_ROULETTE_BANNER"
                file-name="american-roulette"
                folder="home"
            ></file-upload>
            <div class="form-group">
                <label><?php echo e(__('Min bet')); ?></label>
                <input type="number" name="GAME_AMERICAN_ROULETTE_MIN_BET" class="form-control" value="<?php echo e(config('game-american-roulette.min_bet')); ?>">
            </div>
            <div class="form-group">
                <label><?php echo e(__('Max bet')); ?></label>
                <input type="number" name="GAME_AMERICAN_ROULETTE_MAX_BET" class="form-control" value="<?php echo e(config('game-american-roulette.max_bet')); ?>">
            </div>
            <div class="form-group">
                <label><?php echo e(__('Max total bet')); ?></label>
                <input type="number" name="GAME_AMERICAN_ROULETTE_MAX_TOTAL_BET" class="form-control" value="<?php echo e(config('game-american-roulette.max_total_bet')); ?>">
            </div>
            <div class="form-group">
                <label><?php echo e(__('Bet increment / decrement amount')); ?></label>
                <input type="number" name="GAME_AMERICAN_ROULETTE_BET_CHANGE_AMOUNT" class="form-control" value="<?php echo e(config('game-american-roulette.bet_change_amount')); ?>">
            </div>
            <div class="form-group">
                <label><?php echo e(__('Default bet amount')); ?></label>
                <input type="number" name="GAME_AMERICAN_ROULETTE_DEFAULT_BET_AMOUNT" class="form-control" value="<?php echo e(config('game-american-roulette.default_bet_amount')); ?>">
            </div>
        </div>
    </div>
</div>
