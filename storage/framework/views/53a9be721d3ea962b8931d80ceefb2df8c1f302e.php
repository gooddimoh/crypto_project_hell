<?php $__env->startSection('title'); ?>
    <?php echo e(__('Settings')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <form method="POST" action="<?php echo e(route('backend.settings.update')); ?>">
        <?php echo csrf_field(); ?>
        <div class="accordion">
            <div class="card border-primary">
                <div class="card-header border-primary">
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-general" aria-expanded="true">
                            <?php echo e(__('General')); ?>

                        </button>
                    </h5>
                </div>
                <div id="tab-general" class="collapse">
                    <div class="card-body text-body">
                        <div class="form-group">
                            <label><?php echo e(__('Color scheme')); ?></label>
                            <select name="THEME" class="custom-select">
                                <?php $__currentLoopData = $schemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $scheme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($code); ?>" <?php echo e($code==config('settings.theme') ? 'selected' : ''); ?>><?php echo e($scheme); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><?php echo e(__('Layout')); ?></label>
                            <select name="LAYOUT" class="custom-select">
                                <option value="boxed" <?php echo e(config('settings.layout')=='boxed' ? 'selected' : ''); ?>><?php echo e(__('Boxed')); ?></option>
                                <option value="fluid" <?php echo e(config('settings.layout')=='fluid' ? 'selected' : ''); ?>><?php echo e(__('Full-width')); ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><?php echo e(__('Language')); ?></label>
                            <select name="LOCALE" class="custom-select">
                                <?php $__currentLoopData = $locales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $locale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($code); ?>" <?php echo e($code==config('app.locale') ? 'selected' : ''); ?>><?php echo e($locale->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-primary">
                <div class="card-header border-primary">
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-home" aria-expanded="true">
                            <?php echo e(__('Home page')); ?>

                        </button>
                    </h5>
                </div>
                <div id="tab-home" class="collapse">
                    <div class="card-body text-body">
                        <div class="accordion">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-home-slider" aria-expanded="true">
                                            <?php echo e(__('Slider')); ?>

                                        </button>
                                    </h5>
                                </div>
                                <div id="tab-home-slider" class="collapse ml-3">
                                    <div
                                        id="slider-settings"
                                        data-props="<?php echo e(json_encode(['settings' => config('settings.home.slider')], JSON_NUMERIC_CHECK)); ?>"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-primary">
                <div class="card-header border-primary">
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-users" aria-expanded="true">
                            <?php echo e(__('Users')); ?>

                        </button>
                    </h5>
                </div>
                <div id="tab-users" class="collapse">
                    <div class="card-body text-body">
                        <div class="form-group">
                            <div class="form-check">
                                <input type="hidden" name="USERS_EMAIL_VERIFICATION" value="false">
                                <input type="checkbox" name="USERS_EMAIL_VERIFICATION" value="true" class="form-check-input" <?php echo e(config('settings.users.email_verification') ? 'checked="checked"' : ''); ?>>
                                <label class="form-check-label">
                                    <?php echo e(__('Require email verification')); ?>

                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?php echo e(__('Session lifetime')); ?></label>
                            <select name="SESSION_LIFETIME" class="custom-select">
                                <option value="120" <?php echo e(config('session.lifetime')==120 ? 'selected' : ''); ?>><?php echo e(__('2 hours')); ?></option>
                                <option value="720" <?php echo e(config('session.lifetime')==720 ? 'selected' : ''); ?>><?php echo e(__('12 hours')); ?></option>
                                <option value="1440" <?php echo e(config('session.lifetime')==1440 ? 'selected' : ''); ?>><?php echo e(__('24 hours')); ?></option>
                                <option value="10080" <?php echo e(config('session.lifetime')==10080 ? 'selected' : ''); ?>><?php echo e(__('1 week')); ?></option>
                                <option value="10080" <?php echo e(config('session.lifetime')==10080 ? 'selected' : ''); ?>><?php echo e(__('1 week')); ?></option>
                                <option value="43200" <?php echo e(config('session.lifetime')==43200 ? 'selected' : ''); ?>><?php echo e(__('1 month')); ?></option>
                                <option value="525600" <?php echo e(config('session.lifetime')==525600 ? 'selected' : ''); ?>><?php echo e(__('1 year')); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-primary">
                <div class="card-header border-primary">
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-bonuses" aria-expanded="true">
                            <?php echo e(__('Bonuses')); ?>

                        </button>
                    </h5>
                </div>
                <div id="tab-bonuses" class="collapse">
                    <div class="card-body text-body">
                        <div class="form-group">
                            <label><?php echo e(__('User sign up bonus')); ?></label>
                            <input type="text" name="BONUSES_SIGN_UP_CREDITS" class="form-control" value="<?php echo e(config('settings.bonuses.sign_up_credits')); ?>">
                            <small><?php echo e(__('Number of credits given to all users on sign up.')); ?></small>
                        </div>
                        <div class="form-row">
                            <label class="ml-1"><?php echo e(__('Game loss bonus')); ?></label>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?php echo e(__('When net loss')); ?> >=</span>
                                    </div>
                                    <input type="text" name="BONUSES_GAME_LOSS_AMOUNT_MIN" class="form-control" value="<?php echo e(config('settings.bonuses.game.loss_amount_min')); ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><?php echo e(__('credits')); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?php echo e(__('Give back')); ?></span>
                                    </div>
                                    <input type="text" name="BONUSES_GAME_LOSS_AMOUNT_PCT" class="form-control" value="<?php echo e(config('settings.bonuses.game.loss_amount_pct')); ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="ml-1"><?php echo e(__('Game win bonus')); ?></label>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?php echo e(__('When net win')); ?> >=</span>
                                    </div>
                                    <input type="text" name="BONUSES_GAME_WIN_AMOUNT_MIN" class="form-control" value="<?php echo e(config('settings.bonuses.game.win_amount_min')); ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><?php echo e(__('credits')); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?php echo e(__('Give back')); ?></span>
                                    </div>
                                    <input type="text" name="BONUSES_GAME_WIN_AMOUNT_PCT" class="form-control" value="<?php echo e(config('settings.bonuses.game.win_amount_pct')); ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (\Illuminate\Support\Facades\Blade::check('installed', 'payments')): ?>
                            <div class="form-group">
                                <div class="form-row">
                                    <label class="ml-1"><?php echo e(__('Deposit bonus')); ?></label>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-lg-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><?php echo e(__('When deposit')); ?> >=</span>
                                            </div>
                                            <input type="text" name="BONUSES_DEPOSIT_AMOUNT_MIN" class="form-control" value="<?php echo e(config('settings.bonuses.deposit.amount_min')); ?>">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><?php echo e(__('credits')); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><?php echo e(__('Give back')); ?></span>
                                            </div>
                                            <input type="text" name="BONUSES_DEPOSIT_AMOUNT_PCT" class="form-control" value="<?php echo e(config('settings.bonuses.deposit.amount_pct')); ?>">
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <input type="hidden" name="BONUSES_DEPOSIT_AMOUNT_MIN" value="0">
                            <input type="hidden" name="BONUSES_DEPOSIT_AMOUNT_PCT" value="0">
                        <?php endif; ?>
                        <div class="form-group">
                            <label><?php echo e(__('Referee sign up bonus')); ?></label>
                            <div class="input-group">
                                <input type="text" name="BONUSES_REFERRAL_REFEREE_SIGN_UP_CREDITS" class="form-control" value="<?php echo e(config('settings.bonuses.referral.referee_sign_up_credits')); ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text"><?php echo e(__('credits')); ?></span>
                                </div>
                            </div>
                            <small><?php echo e(__('How much will the referred user get when signing up using a referral link.')); ?></small>
                            <small><?php echo e(__('This setting can be overridden on the user level.')); ?></small>
                        </div>
                        <div class="form-group">
                            <label><?php echo e(__('Referrer sign up bonus')); ?></label>
                            <div class="input-group">
                                <input type="text" name="BONUSES_REFERRAL_REFERRER_SIGN_UP_CREDITS" class="form-control" value="<?php echo e(config('settings.bonuses.referral.referrer_sign_up_credits')); ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text"><?php echo e(__('credits')); ?></span>
                                </div>
                            </div>
                            <small><?php echo e(__('How much will the referrer user get when anyone signs up using their referral link.')); ?></small>
                            <small><?php echo e(__('This setting can be overridden on the user level.')); ?></small>
                        </div>
                        <div class="form-group">
                            <label><?php echo e(__('Referrer game loss bonus')); ?></label>
                            <div class="input-group">
                                <input type="text" name="BONUSES_REFERRAL_REFERRER_GAME_LOSS_PCT" class="form-control" value="<?php echo e(config('settings.bonuses.referral.referrer_game_loss_pct')); ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            <small><?php echo e(__('How much (% of the net loss) will the referrer user get when a referred user loses a game.')); ?></small>
                            <small><?php echo e(__('This setting can be overridden on the user level.')); ?></small>
                        </div>
                        <div class="form-group">
                            <label><?php echo e(__('Referrer game win bonus')); ?></label>
                            <div class="input-group">
                                <input type="text" name="BONUSES_REFERRAL_REFERRER_GAME_WIN_PCT" class="form-control" value="<?php echo e(config('settings.bonuses.referral.referrer_game_win_pct')); ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            <small><?php echo e(__('How much (% of the net win) will the referrer user get when a referred user wins a game.')); ?></small>
                            <small><?php echo e(__('This setting can be overridden on the user level.')); ?></small>
                        </div>
                        <?php if (\Illuminate\Support\Facades\Blade::check('installed', 'raffle')): ?>
                            <div class="form-group">
                                <label><?php echo e(__('Referrer raffle ticket purchase bonus')); ?></label>
                                <div class="input-group">
                                    <input type="text" name="BONUSES_RAFFLE_TICKET_PCT" class="form-control" value="<?php echo e(config('settings.bonuses.raffle.ticket_pct')); ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <small><?php echo e(__('How much (% of the ticket price) will the referrer user get when a referred user purchases a raffle ticket.')); ?></small>
                            </div>
                        <?php else: ?>
                            <input type="hidden" name="BONUSES_RAFFLE_TICKET_PCT" value="0">
                        <?php endif; ?>
                        <?php if (\Illuminate\Support\Facades\Blade::check('installed', 'payments')): ?>
                            <div class="form-group">
                                <label><?php echo e(__('Referrer deposit bonus')); ?></label>
                                <div class="input-group">
                                    <input type="text" name="BONUSES_REFERRAL_REFERRER_DEPOSIT_PCT" class="form-control" value="<?php echo e(config('settings.bonuses.referral.referrer_deposit_pct')); ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <small><?php echo e(__('How much (% of the deposit amount) will the referrer user get when a referred user completes a deposit.')); ?></small>
                                <small><?php echo e(__('This setting can be overridden on the user level.')); ?></small>
                            </div>
                        <?php else: ?>
                            <input type="hidden" name="BONUSES_REFERRAL_REFERRER_DEPOSIT_PCT" value="0">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="card border-primary">
                <div class="card-header border-primary">
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-bots" aria-expanded="true">
                            <?php echo e(__('Bots')); ?>

                        </button>
                    </h5>
                </div>
                <div id="tab-bots" class="collapse">
                    <div class="card-body text-body">
                        <p class="ml-1">
                            <?php echo __('Bots can be created or deleted on the <a href=":url">Maintenance page</a>', ['url' => route('backend.maintenance.index')]); ?>

                        </p>
                        <div class="accordion">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-bots-games" aria-expanded="true">
                                            <?php echo e(__('Games')); ?>

                                        </button>
                                    </h5>
                                </div>
                                <div id="tab-bots-games" class="collapse ml-3">
                                    <div class="card-body">
                                        <p>
                                            <?php echo e(__('Periodically (depending on the frequency setting) a random number of bots will be selected (according to min and max bots settings).')); ?>

                                            <?php echo e(__('Then every selected bot will play exactly one game with random parameters.')); ?>

                                        </p>
                                        <div class="form-group">
                                            <label><?php echo e(__('Frequency')); ?></label>
                                            <select name="BOTS_PLAY_FREQUENCY" class="custom-select">
                                                <option value="1" <?php echo e(config('settings.bots.game.frequency')==1 ? 'selected' : ''); ?>><?php echo e(__('Every minute')); ?></option>
                                                <option value="5" <?php echo e(config('settings.bots.game.frequency')==5 ? 'selected' : ''); ?>><?php echo e(__('Every 5 minutes')); ?></option>
                                                <option value="10" <?php echo e(config('settings.bots.game.frequency')==10 ? 'selected' : ''); ?>><?php echo e(__('Every 10 minutes')); ?></option>
                                                <option value="15" <?php echo e(config('settings.bots.game.frequency')==15 ? 'selected' : ''); ?>><?php echo e(__('Every 15 minutes')); ?></option>
                                                <option value="30" <?php echo e(config('settings.bots.game.frequency')==30 ? 'selected' : ''); ?>><?php echo e(__('Every 30 minutes')); ?></option>
                                            </select>
                                            <small><?php echo e(__('Choose how often bots will awake.')); ?></small>
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo e(__('Min bots')); ?></label>
                                            <input type="text" name="BOTS_SELECT_COUNT_MIN" class="form-control" value="<?php echo e(config('settings.bots.game.count_min')); ?>">
                                            <small><?php echo e(__('Minimum number of bots to play a game during each cycle.')); ?></small>
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo e(__('Max bots')); ?></label>
                                            <input type="text" name="BOTS_SELECT_COUNT_MAX" class="form-control" value="<?php echo e(config('settings.bots.game.count_max')); ?>">
                                            <small><?php echo e(__('Maximum number of bots to play a game during each cycle.')); ?></small>
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo e(__('Min bet')); ?></label>
                                            <div class="input-group">
                                                <input type="text" name="BOTS_MIN_BET" class="form-control" value="<?php echo e(config('settings.bots.game.min_bet')); ?>">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><?php echo e(__('credits')); ?></span>
                                                </div>
                                            </div>
                                            <small>
                                                <?php echo e(__('Minimum bet a bot is allowed to make.')); ?>

                                                <?php echo e(__('Leave empty to use the limit specified in the game settings.')); ?>

                                            </small>
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo e(__('Max bet')); ?></label>
                                            <div class="input-group">
                                                <input type="text" name="BOTS_MAX_BET" class="form-control" value="<?php echo e(config('settings.bots.game.max_bet')); ?>">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><?php echo e(__('credits')); ?></span>
                                                </div>
                                            </div>
                                            <small>
                                                <?php echo e(__('Maximum bet a bot is allowed to make.')); ?>

                                                <?php echo e(__('Leave empty to use the limit specified in the game settings.')); ?>

                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <?php if (\Illuminate\Support\Facades\Blade::check('installed', 'raffle')): ?>
                                    <div class="card-header">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-bots-raffles" aria-expanded="true">
                                                <?php echo e(__('Raffles')); ?>

                                            </button>
                                        </h5>
                                    </div>
                                    <div id="tab-bots-raffles" class="collapse ml-3">
                                        <div class="card-body">
                                            <p>
                                                <?php echo e(__('Periodically (depending on the frequency setting) a random number of bots will be selected (according to min and max bots settings).')); ?>

                                                <?php echo e(__('Then every selected bot will purchase a random number of raffle tickets.')); ?>

                                            </p>
                                            <div class="form-group">
                                                <label><?php echo e(__('Frequency')); ?></label>
                                                <select name="BOTS_RAFFLE_FREQUENCY" class="custom-select">
                                                    <option value="1" <?php echo e(config('settings.bots.raffle.frequency')==1 ? 'selected' : ''); ?>><?php echo e(__('Every minute')); ?></option>
                                                    <option value="5" <?php echo e(config('settings.bots.raffle.frequency')==5 ? 'selected' : ''); ?>><?php echo e(__('Every 5 minutes')); ?></option>
                                                    <option value="10" <?php echo e(config('settings.bots.raffle.frequency')==10 ? 'selected' : ''); ?>><?php echo e(__('Every 10 minutes')); ?></option>
                                                    <option value="15" <?php echo e(config('settings.bots.raffle.frequency')==15 ? 'selected' : ''); ?>><?php echo e(__('Every 15 minutes')); ?></option>
                                                    <option value="30" <?php echo e(config('settings.bots.raffle.frequency')==30 ? 'selected' : ''); ?>><?php echo e(__('Every 30 minutes')); ?></option>
                                                </select>
                                                <small><?php echo e(__('Choose how often bots will awake.')); ?></small>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo e(__('Min bots')); ?></label>
                                                <input type="text" name="BOTS_RAFFLE_COUNT_MIN" class="form-control" value="<?php echo e(config('settings.bots.raffle.count_min')); ?>">
                                                <small><?php echo e(__('Minimum number of bots to purchase raffle tickets.')); ?></small>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo e(__('Max bots')); ?></label>
                                                <input type="text" name="BOTS_RAFFLE_COUNT_MAX" class="form-control" value="<?php echo e(config('settings.bots.raffle.count_max')); ?>">
                                                <small><?php echo e(__('Maximum number of bots to purchase raffle tickets.')); ?></small>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo e(__('Min tickets')); ?></label>
                                                <input type="text" name="BOTS_RAFFLE_TICKETS_MIN" class="form-control" value="<?php echo e(config('settings.bots.raffle.tickets_min')); ?>">
                                                <small><?php echo e(__('Minimum number of tickets to purchase during each cycle.')); ?></small>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo e(__('Max tickets')); ?></label>
                                                <input type="text" name="BOTS_RAFFLE_TICKETS_MAX" class="form-control" value="<?php echo e(config('settings.bots.raffle.tickets_max')); ?>">
                                                <small><?php echo e(__('Maximum number of tickets to purchase during each cycle.')); ?></small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-primary">
                <div class="card-header border-primary">
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-numbers" aria-expanded="true">
                            <?php echo e(__('Number formatting')); ?>

                        </button>
                    </h5>
                </div>
                <div id="tab-numbers" class="collapse">
                    <div class="card-body text-body">
                        <div class="form-group">
                            <label><?php echo e(__('Decimal point')); ?></label>
                            <select name="FORMAT_NUMBER_DECIMAL_POINT" class="custom-select">
                                <?php $__currentLoopData = $separators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $separator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($code); ?>" <?php echo e($code==config('settings.format.number.decimal_point') ? 'selected' : ''); ?>><?php echo e($separator); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><?php echo e(__('Thousands separator')); ?></label>
                            <select name="FORMAT_NUMBER_THOUSANDS_SEPARATOR" class="custom-select">
                                <?php $__currentLoopData = $separators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $separator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($code); ?>" <?php echo e($code==config('settings.format.number.thousands_separator') ? 'selected' : ''); ?>><?php echo e($separator); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-primary">
                <div class="card-header border-primary">
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-mail" aria-expanded="true">
                            <?php echo e(__('Mail')); ?>

                        </button>
                    </h5>
                </div>
                <div id="tab-mail" class="collapse">
                    <div class="accordion">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-mail-driver" aria-expanded="true">
                                        <?php echo e(__('Driver')); ?>

                                    </button>
                                </h5>
                            </div>
                            <div id="tab-mail-driver" class="collapse ml-3">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label><?php echo e(__('Mail driver')); ?></label>
                                        <select name="MAIL_DRIVER" class="custom-select">
                                            <option value="sendmail" <?php echo e(config('mail.driver')=='sendmail' ? 'selected' : ''); ?>><?php echo e(__('SendMail')); ?></option>
                                            <option value="smtp" <?php echo e(config('mail.driver')=='smtp' ? 'selected' : ''); ?>><?php echo e(__('SMTP')); ?></option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo e(__('SMTP host')); ?></label>
                                        <input type="text" name="MAIL_HOST" class="form-control" value="<?php echo e(config('mail.host')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo e(__('SMTP port')); ?></label>
                                        <input type="text" name="MAIL_PORT" class="form-control" value="<?php echo e(config('mail.port')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo e(__('SMTP email from address')); ?></label>
                                        <input type="text" name="MAIL_FROM_ADDRESS" class="form-control" value="<?php echo e(config('mail.from.address')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo e(__('SMTP email from name')); ?></label>
                                        <input type="text" name="MAIL_FROM_NAME" class="form-control" value="<?php echo e(config('mail.from.name')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo e(__('SMTP user')); ?></label>
                                        <input type="text" name="MAIL_USERNAME" class="form-control" value="<?php echo e(config('mail.username')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo e(__('SMTP password')); ?></label>
                                        <input type="password" name="MAIL_PASSWORD" class="form-control" value="<?php echo e(config('mail.password')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo e(__('Mail encryption')); ?></label>
                                        <select name="MAIL_ENCRYPTION" class="custom-select">
                                            <option value="" <?php echo e(!config('mail.encryption') ? 'selected' : ''); ?>><?php echo e(__('None')); ?></option>
                                            <option value="tls" <?php echo e(config('mail.encryption')=='tls' ? 'selected' : ''); ?>><?php echo e(__('TLS')); ?></option>
                                            <option value="ssl" <?php echo e(config('mail.encryption')=='ssl' ? 'selected' : ''); ?>><?php echo e(__('SSL')); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-mail-notifications" aria-expanded="true">
                                        <?php echo e(__('Notifications')); ?>

                                    </button>
                                </h5>
                            </div>
                            <div id="tab-mail-notifications" class="collapse ml-3">
                                <div class="accordion">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-mail-notifications-admin" aria-expanded="true">
                                                    <?php echo e(__('Admin')); ?>

                                                </button>
                                            </h5>
                                        </div>
                                        <div id="tab-mail-notifications-admin" class="collapse ml-5">
                                            <div class="form-group">
                                                <label><?php echo e(__('Email')); ?></label>
                                                <input type="text" name="NOTIFICATIONS_ADMIN_EMAIL" class="form-control" value="<?php echo e(config('settings.notifications.admin.email')); ?>">
                                            </div>
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input type="hidden" name="NOTIFICATIONS_ADMIN_REGISTRATION_ENABLED" value="false">
                                                    <input type="checkbox" name="NOTIFICATIONS_ADMIN_REGISTRATION_ENABLED" value="true" class="form-check-input" <?php echo e(config('settings.notifications.admin.registration.enabled') ? 'checked="checked"' : ''); ?>>
                                                    <label class="form-check-label">
                                                        <?php echo e(__('Notify when a new user signs up')); ?>

                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-inline">
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <input type="hidden" name="NOTIFICATIONS_ADMIN_GAME_WIN_ENABLED" value="false">
                                                            <input type="checkbox" name="NOTIFICATIONS_ADMIN_GAME_WIN_ENABLED" value="true" class="form-check-input" <?php echo e(config('settings.notifications.admin.game.win.enabled') ? 'checked="checked"' : ''); ?>>
                                                            <label class="form-check-label">
                                                                <?php echo e(__('Notify when a user wins more than (in one game)')); ?>

                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group ml-2">
                                                        <input type="text" name="NOTIFICATIONS_ADMIN_GAME_WIN_TRESHOLD" class="form-control" value="<?php echo e(config('settings.notifications.admin.game.win.treshold')); ?>">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><?php echo e(__('credits')); ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-inline">
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <input type="hidden" name="NOTIFICATIONS_ADMIN_GAME_LOSS_ENABLED" value="false">
                                                            <input type="checkbox" name="NOTIFICATIONS_ADMIN_GAME_LOSS_ENABLED" value="true" class="form-check-input" <?php echo e(config('settings.notifications.admin.game.loss.enabled') ? 'checked="checked"' : ''); ?>>
                                                            <label class="form-check-label">
                                                                <?php echo e(__('Notify when a user loses more than (in one game)')); ?>

                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="input-group ml-2">
                                                        <input type="text" name="NOTIFICATIONS_ADMIN_GAME_LOSS_TRESHOLD" class="form-control" value="<?php echo e(config('settings.notifications.admin.game.loss.treshold')); ?>">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><?php echo e(__('credits')); ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-primary">
                <div class="card-header border-primary">
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-integration" aria-expanded="true">
                            <?php echo e(__('Integration')); ?>

                        </button>
                    </h5>
                </div>
                <div id="tab-integration" class="collapse">
                    <div class="card-body">
                        <div class="accordion">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-integration-gtm" aria-expanded="true">
                                            <?php echo e(__('Google Tag Manager')); ?>

                                        </button>
                                    </h5>
                                </div>
                                <div id="tab-integration-gtm" class="collapse ml-3">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label><?php echo e(__('Container ID')); ?></label>
                                            <input type="text" name="GTM_CONTAINER_ID" class="form-control" value="<?php echo e(config('settings.gtm_container_id')); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-integration-recaptcha" aria-expanded="true">
                                            <?php echo e(__('Google reCaptcha')); ?>

                                        </button>
                                    </h5>
                                </div>
                                <div id="tab-integration-recaptcha" class="collapse ml-3">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label><?php echo e(__('Public key')); ?></label>
                                            <input type="text" name="RECAPTCHA_PUBLIC_KEY" class="form-control" value="<?php echo e(config('settings.recaptcha.public_key')); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo e(__('Private key')); ?></label>
                                            <input type="text" name="RECAPTCHA_SECRET_KEY" class="form-control" value="<?php echo e(config('settings.recaptcha.secret_key')); ?>">
                                            <small>
                                                <?php echo e(__('Leave empty if you do not want to use reCaptcha validation. Public and private keys can be obtained at :url', ['url' => 'https://www.google.com/recaptcha'])); ?>

                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-integration-pusher" aria-expanded="true">
                                            <?php echo e(__('Pusher')); ?>

                                        </button>
                                    </h5>
                                </div>
                                <div id="tab-integration-pusher" class="collapse ml-3">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <input type="hidden" name="BROADCAST_DRIVER" value="pusher">
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo e(__('App ID')); ?></label>
                                            <input type="text" name="PUSHER_APP_ID" class="form-control" value="<?php echo e(config('broadcasting.connections.pusher.app_id')); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo e(__('App key')); ?></label>
                                            <input type="text" name="PUSHER_APP_KEY" class="form-control" value="<?php echo e(config('broadcasting.connections.pusher.key')); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo e(__('App secret')); ?></label>
                                            <input type="text" name="PUSHER_APP_SECRET" class="form-control" value="<?php echo e(config('broadcasting.connections.pusher.secret')); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo e(__('Cluster')); ?></label>
                                            <input type="text" name="PUSHER_APP_CLUSTER" class="form-control" value="<?php echo e(config('broadcasting.connections.pusher.options.cluster')); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $__currentLoopData = array_keys(config('services.login_providers')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-integration-<?php echo e($provider); ?>" aria-expanded="true">
                                                <?php echo e(ucfirst($provider)); ?>

                                            </button>
                                        </h5>
                                    </div>
                                    <div id="tab-integration-<?php echo e($provider); ?>" class="collapse ml-3">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label><?php echo e(__('Client ID')); ?></label>
                                                <input type="text" name="<?php echo e(strtoupper($provider)); ?>_CLIENT_ID" value="<?php echo e(config('services.'.$provider.'.client_id')); ?>" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo e(__('Client secret')); ?></label>
                                                <input type="text" name="<?php echo e(strtoupper($provider)); ?>_CLIENT_SECRET" value="<?php echo e(config('services.'.$provider.'.client_secret')); ?>" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo e(__('Redirect URL')); ?></label>
                                                <input type="text" value="<?php echo e(url(config('services.'.$provider.'.redirect'))); ?>" class="form-control" disabled="disabled">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-primary">
                <div class="card-header border-primary">
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-developer" aria-expanded="true">
                            <?php echo e(__('Developer')); ?>

                        </button>
                    </h5>
                </div>
                <div id="tab-developer" class="collapse">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-check">
                                <input type="hidden" name="APP_DEBUG" value="false">
                                <input type="checkbox" name="APP_DEBUG" value="true" class="form-check-input" <?php echo e(config('app.debug') ? 'checked="checked"' : ''); ?>>
                                <label class="form-check-label">
                                    <?php echo e(__('Debug mode')); ?>

                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?php echo e(__('Log level')); ?></label>
                            <select name="APP_LOG_LEVEL" class="custom-select">
                                <?php $__currentLoopData = $log_levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log_level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($log_level); ?>" <?php echo e($log_level==env('APP_LOG_LEVEL', 'emergency') ? 'selected' : ''); ?>><?php echo e(__(ucfirst($log_level))); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo $__env->make("game-american-roulette::backend.pages.settings", array_except(get_defined_vars(), array("__data", "__path")))->render();echo $__env->make("game-blackjack::backend.pages.settings", array_except(get_defined_vars(), array("__data", "__path")))->render();echo $__env->make("game-dice-3d::backend.pages.settings", array_except(get_defined_vars(), array("__data", "__path")))->render();echo $__env->make("game-slots::backend.pages.settings", array_except(get_defined_vars(), array("__data", "__path")))->render();echo $__env->make("payments::backend.pages.settings", array_except(get_defined_vars(), array("__data", "__path")))->render();?>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary"><?php echo e(__('Save')); ?></button>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript" src="<?php echo e(mix('js/pages/admin/settings.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>