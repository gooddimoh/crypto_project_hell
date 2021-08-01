<div class="card border-primary">
    <div class="card-header border-primary">
        <h5 class="mb-0">
            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-deposits-withdrawals" aria-expanded="true">
                <?php echo e(__('Deposits & Withdrawals')); ?>

            </button>
        </h5>
    </div>
    <div id="tab-deposits-withdrawals" class="collapse">
        <div class="card-body">
            <div class="accordion">
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
                                        <div class="form-inline">
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input type="hidden" name="PAYMENTS_NOTIFICATIONS_ADMIN_DEPOSIT_ENABLED" value="false">
                                                    <input type="checkbox" name="PAYMENTS_NOTIFICATIONS_ADMIN_DEPOSIT_ENABLED" value="true" class="form-check-input" <?php echo e(config('payments.notifications.admin.deposit.enabled') ? 'checked="checked"' : ''); ?>>
                                                    <label class="form-check-label">
                                                        <?php echo e(__('Notify after a user completes a deposit greater than')); ?>

                                                    </label>
                                                </div>
                                            </div>
                                            <div class="input-group ml-2">
                                                <input type="text" name="PAYMENTS_NOTIFICATIONS_ADMIN_DEPOSIT_TRESHOLD" class="form-control" value="<?php echo e(config('payments.notifications.admin.deposit.treshold')); ?>">
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
                                                    <input type="hidden" name="PAYMENTS_NOTIFICATIONS_ADMIN_WITHDRAWAL_ENABLED" value="false">
                                                    <input type="checkbox" name="PAYMENTS_NOTIFICATIONS_ADMIN_WITHDRAWAL_ENABLED" value="true" class="form-check-input" <?php echo e(config('payments.notifications.admin.withdrawal.enabled') ? 'checked="checked"' : ''); ?>>
                                                    <label class="form-check-label">
                                                        <?php echo e(__('Notify after a user creates a withdrawal greater than')); ?>

                                                    </label>
                                                </div>
                                            </div>
                                            <div class="input-group ml-2">
                                                <input type="text" name="PAYMENTS_NOTIFICATIONS_ADMIN_WITHDRAWAL_TRESHOLD" class="form-control" value="<?php echo e(config('payments.notifications.admin.withdrawal.treshold')); ?>">
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
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-deposits" aria-expanded="true">
                                <?php echo e(__('Deposits')); ?>

                            </button>
                        </h5>
                    </div>
                    <div id="tab-deposits" class="collapse ml-3">
                        <div class="card-body">
                            <div class="form-group">
                                <label><?php echo e(__('Min deposit amount')); ?></label>
                                <div class="input-group">
                                    <input type="text" name="PAYMENTS_DEPOSIT_MIN" class="form-control" value="<?php echo e(config('payments.deposit_min')); ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><?php echo e(__('credits')); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('Max deposit amount')); ?></label>
                                <div class="input-group">
                                    <input type="text" name="PAYMENTS_DEPOSIT_MAX" class="form-control" value="<?php echo e(config('payments.deposit_max')); ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><?php echo e(__('credits')); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-withdrawals" aria-expanded="true">
                                <?php echo e(__('Withdrawals')); ?>

                            </button>
                        </h5>
                    </div>
                    <div id="tab-withdrawals" class="collapse ml-3">
                        <div class="card-body">
                            <div class="form-group">
                                <label><?php echo e(__('Min withdrawal amount')); ?></label>
                                <div class="input-group">
                                    <input type="text" name="PAYMENTS_WITHDRAWAL_MIN" class="form-control" value="<?php echo e(config('payments.withdrawal_min')); ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><?php echo e(__('credits')); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('Max withdrawal amount')); ?></label>
                                <div class="input-group">
                                    <input type="text" name="PAYMENTS_WITHDRAWAL_MAX" class="form-control" value="<?php echo e(config('payments.withdrawal_max')); ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><?php echo e(__('credits')); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('Min total deposit amount to allow withdrawal')); ?></label>
                                <div class="input-group">
                                    <input type="text" name="PAYMENTS_MIN_TOTAL_DEPOSIT_TO_WITHDRAW" class="form-control" value="<?php echo e(config('payments.min_total_deposit_to_withdraw')); ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><?php echo e(__('credits')); ?></span>
                                    </div>
                                </div>
                                <small>
                                    <?php echo e(__('User will need to deposit at least that amount before being able to withdraw funds.')); ?>

                                    <?php echo e(__('Set the value to 0 if you do not want to limit withdrawals.')); ?>

                                </small>
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('Auto approve and process withdrawals less than or equal to')); ?></label>
                                <div class="input-group">
                                    <input type="text" name="PAYMENTS_WITHDRAWAL_AUTO_MAX" class="form-control" value="<?php echo e(config('payments.withdrawal_auto_max')); ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><?php echo e(__('credits')); ?></span>
                                    </div>
                                </div>
                                <small>
                                    <?php echo e(__('Please note that even though such withdrawals will be processed automatically on the application side an extra email confirmation might be required on the payments provider side (see coinpayments.net settings).')); ?>

                                    <?php echo e(__('Leave zero if you like to manually approve all withdrawals.')); ?>

                                </small>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input type="hidden" name="PAYMENTS_WITHDRAWAL_ONLY_PROFITS" value="false">
                                    <input id="withdrawal_only_profits" type="checkbox" name="PAYMENTS_WITHDRAWAL_ONLY_PROFITS" value="true" class="form-check-input" <?php echo e(config('payments.withdrawal_only_profits') ? 'checked="checked"' : ''); ?>>
                                    <label for="withdrawal_only_profits" class="form-check-label">
                                        <?php echo e(__('Allow only profit withdrawals')); ?>

                                    </label>
                                    <div>
                                        <small>
                                            <?php echo e(__('Check that withdrawal amount does not exceed games profits and previously made deposits.')); ?>

                                            <?php echo e(__('This means that bonuses can not be withdrawn directly unless they spent to play games.')); ?>

                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-paypal" aria-expanded="true">
                                <?php echo e(__('PayPal')); ?>

                            </button>
                        </h5>
                    </div>
                    <div id="tab-paypal" class="collapse ml-3">
                        <div class="card-body">
                            <div class="form-group">
                                <label><?php echo e(__('API user')); ?></label>
                                <input type="text" name="PAYMENTS_PAYPAL_USER" class="form-control" value="<?php echo e(config('payments.paypal.user')); ?>">
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('API password')); ?></label>
                                <input type="text" name="PAYMENTS_PAYPAL_PASSWORD" class="form-control" value="<?php echo e(config('payments.paypal.password')); ?>">
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('API signature')); ?></label>
                                <input type="text" name="PAYMENTS_PAYPAL_SIGNATURE" class="form-control" value="<?php echo e(config('payments.paypal.signature')); ?>">
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input type="hidden" name="PAYMENTS_PAYPAL_TEST_MODE" value="false">
                                    <input id="paypal_test_mode" type="checkbox" name="PAYMENTS_PAYPAL_TEST_MODE" value="true" class="form-check-input" <?php echo e(config('payments.paypal.test_mode') ? 'checked="checked"' : ''); ?>>
                                    <label for="paypal_test_mode" class="form-check-label">
                                        <?php echo e(__('Test mode')); ?>

                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-stripe" aria-expanded="true">
                                <?php echo e(__('Stripe')); ?>

                            </button>
                        </h5>
                    </div>
                    <div id="tab-stripe" class="collapse ml-3">
                        <div class="card-body">
                            <div class="form-group">
                                <label><?php echo e(__('Public key')); ?></label>
                                <input type="text" name="PAYMENTS_STRIPE_PUBLIC_KEY" class="form-control" value="<?php echo e(config('payments.stripe.public_key')); ?>">
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('Secret key')); ?></label>
                                <input type="text" name="PAYMENTS_STRIPE_SECRET_KEY" class="form-control" value="<?php echo e(config('payments.stripe.secret_key')); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-coinpayments" aria-expanded="true">
                                <?php echo e(__('Coinpayments.net')); ?>

                            </button>
                        </h5>
                    </div>
                    <div id="tab-coinpayments" class="collapse ml-3">
                        <div class="card-body">
                            <div class="form-group">
                                <label><?php echo e(__('Merchant ID')); ?></label>
                                <input type="text" name="PAYMENTS_COINPAYMENTS_MERCHANT_ID" class="form-control" value="<?php echo e(config('payments.coinpayments.merchant_id')); ?>">
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('Public key')); ?></label>
                                <input type="text" name="PAYMENTS_COINPAYMENTS_PUBLIC_KEY" class="form-control" value="<?php echo e(config('payments.coinpayments.public_key')); ?>">
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('Private key')); ?></label>
                                <input type="text" name="PAYMENTS_COINPAYMENTS_PRIVATE_KEY" class="form-control" value="<?php echo e(config('payments.coinpayments.private_key')); ?>">
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('Secret key')); ?></label>
                                <input type="text" name="PAYMENTS_COINPAYMENTS_SECRET_KEY" class="form-control" value="<?php echo e(config('payments.coinpayments.secret_key')); ?>">
                                <small>
                                    <?php echo e(__('Please input any random string nobody can guess (example: :string). This should be the same as IPN secret field in your coinpayments.net account (Account Settings -> Merchant Settings).', ['string' => str_random(20)])); ?>

                                </small>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input type="hidden" name="PAYMENTS_COINPAYMENTS_AUTO_CONFIRM_WITHDRAWALS" value="false">
                                    <input id="withdrawals_auto_confirm" type="checkbox" name="PAYMENTS_COINPAYMENTS_AUTO_CONFIRM_WITHDRAWALS" value="true" class="form-check-input" <?php echo e(config('payments.coinpayments.withdrawals_auto_confirm') ? 'checked="checked"' : ''); ?>>
                                    <label for="withdrawals_auto_confirm" class="form-check-label">
                                        <?php echo e(__('Auto confirm all withdrawals (do not require email confirmation)')); ?>

                                    </label>
                                    <div>
                                        <small>
                                            <?php echo e(__('Please note that this setting only affects whether an extra email confirmation is required for all withdrawals from your coinpayments.net account.')); ?>

                                            <?php echo e(__('You also need to set "Allow auto_confirm = 1 in create_withdrawal" permission in your coinpayments.net account for the given API key.')); ?>

                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-ethereum" aria-expanded="true">
                                <?php echo e(__('Ethereum')); ?>

                            </button>
                        </h5>
                    </div>
                    <div id="tab-ethereum" class="collapse ml-3">
                        <div class="card-body">
                            <div class="form-group">
                                <label><?php echo e(__('Etherscan.io API key')); ?></label>
                                <input type="text" name="PAYMENTS_ETHEREUM_ETHERSCAN_API_KEY" class="form-control" value="<?php echo e(config('payments.ethereum.api_key')); ?>">
                                <small>
                                    <?php echo e(__('Required to fetch transactions info from the blockchain.')); ?>

                                </small>
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('Ethereum network')); ?></label>
                                <select name="PAYMENTS_ETHEREUM_NETWORK" class="custom-select">
                                    <option value="main" <?php echo e(config('payments.ethereum.network')=='main'?'selected':''); ?>><?php echo e(__('Main Ethereum network')); ?></option>
                                    <option value="kovan" <?php echo e(config('payments.ethereum.network')=='kovan'?'selected':''); ?>><?php echo e(__('Kovan test network')); ?></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('Deposit address')); ?></label>
                                <input type="text" name="PAYMENTS_ETHEREUM_DEPOSIT_ADDRESS" class="form-control" value="<?php echo e(config('payments.ethereum.deposit_address')); ?>">
                                <small>
                                    <?php echo e(__('The address of your wallet, where deposited coins will be sent to.')); ?>

                                </small>
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('ERC20 token contract address')); ?></label>
                                <input type="text" name="PAYMENTS_ETHEREUM_DEPOSIT_CONTRACT" class="form-control" value="<?php echo e(config('payments.ethereum.deposit_contract')); ?>">
                                <small>
                                    <?php echo e(__('Fill it if you like to receive an ERC20 token instead of ETH, otherwise leave empty.')); ?>

                                </small>
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('ERC20 token contract decimals')); ?></label>
                                <input type="text" name="PAYMENTS_ETHEREUM_DEPOSIT_CONTRACT_DECIMALS" class="form-control" value="<?php echo e(config('payments.ethereum.deposit_contract_decimals')); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-bsc" aria-expanded="true">
                                <?php echo e(__('Binance Smart Chain')); ?>

                            </button>
                        </h5>
                    </div>
                    <div id="tab-bsc" class="collapse ml-3">
                        <div class="card-body">
                            <div class="form-group">
                                <label><?php echo e(__('Bscscan.com API key')); ?></label>
                                <input type="text" name="PAYMENTS_BSC_EXPLORER_API_KEY" class="form-control" value="<?php echo e(config('payments.bsc.api_key')); ?>">
                                <small>
                                    <?php echo e(__('Required to fetch transactions info from the blockchain.')); ?>

                                </small>
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('Network')); ?></label>
                                <select name="PAYMENTS_BSC_NETWORK" class="custom-select">
                                    <option value="bsc-main" <?php echo e(config('payments.bsc.network')=='bsc-main'?'selected':''); ?>><?php echo e(__('Main network')); ?></option>
                                    <option value="bsc-test" <?php echo e(config('payments.bsc.network')=='bsc-test'?'selected':''); ?>><?php echo e(__('Test network')); ?></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('Deposit address')); ?></label>
                                <input type="text" name="PAYMENTS_BSC_DEPOSIT_ADDRESS" class="form-control" value="<?php echo e(config('payments.bsc.deposit_address')); ?>">
                                <small>
                                    <?php echo e(__('The address of your wallet, where deposited coins will be sent to.')); ?>

                                </small>
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('BEP20 token contract address')); ?></label>
                                <input type="text" name="PAYMENTS_BSC_DEPOSIT_CONTRACT" class="form-control" value="<?php echo e(config('payments.bsc.deposit_contract')); ?>">
                                <small>
                                    <?php echo e(__('Fill it if you like to receive an BEP20 token instead of BNB, otherwise leave empty.')); ?>

                                </small>
                            </div>
                            <div class="form-group">
                                <label><?php echo e(__('BEP20 token contract decimals')); ?></label>
                                <input type="text" name="PAYMENTS_BSC_DEPOSIT_CONTRACT_DECIMALS" class="form-control" value="<?php echo e(config('payments.bsc.deposit_contract_decimals')); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
