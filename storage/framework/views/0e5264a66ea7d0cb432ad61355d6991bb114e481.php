<div class="card border-primary">
    <div class="card-header border-primary">
        <h5 class="mb-0">
            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-game-blackjack" aria-expanded="true">
                <?php echo e(__('Game: :game', ['game' => __('Blackjack')])); ?>

            </button>
        </h5>
    </div>
    <div id="tab-game-blackjack" class="collapse">
        <div class="card-body">
            <div class="form-group">
                <label><?php echo e(__('Categories')); ?></label>
                <input type="text" name="GAME_BLACKJACKT_CATEGORIES" class="form-control" value="<?php echo e(config('game-blackjack.categories')); ?>">
                <small><?php echo e(__('Comma-delimited list')); ?></small>
            </div>
            <file-upload
                label="<?php echo e(__('Banner')); ?>"
                path="<?php echo e(config('game-blackjack.banner')); ?>"
                name="GAME_BLACKJACK_BANNER"
                file-name="blackjack"
                folder="home"
            ></file-upload>
            <div class="form-group">
                <label><?php echo e(__('Min bet')); ?></label>
                <input type="number" name="GAME_BLACKJACK_MIN_BET" class="form-control" value="<?php echo e(config('game-blackjack.min_bet')); ?>">
            </div>
            <div class="form-group">
                <label><?php echo e(__('Max bet')); ?></label>
                <input type="number" name="GAME_BLACKJACK_MAX_BET" class="form-control" value="<?php echo e(config('game-blackjack.max_bet')); ?>">
            </div>
            <div class="form-group">
                <label><?php echo e(__('Bet increment / decrement amount')); ?></label>
                <input type="number" name="GAME_BLACKJACK_BET_CHANGE_AMOUNT" class="form-control" value="<?php echo e(config('game-blackjack.bet_change_amount')); ?>">
            </div>
            <div class="form-group">
                <label><?php echo e(__('Default bet amount')); ?></label>
                <input type="number" name="GAME_BLACKJACK_DEFAULT_BET_AMOUNT" class="form-control" value="<?php echo e(config('game-blackjack.default_bet_amount')); ?>">
            </div>
        </div>
    </div>
</div>
