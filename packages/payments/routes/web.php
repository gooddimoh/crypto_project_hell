<?php

// frontend
Route::name('frontend.')
    ->namespace('Packages\Payments\Http\Controllers\Frontend')
    ->middleware(['web', 'auth', 'active', 'email_verified', '2fa']) // it's important to add web middleware as it's not automatically added for packages routes
    ->group(function () {
        // deposits
        Route::get('user/deposits', 'DepositController@index')->name('deposits.index');
        Route::get('user/deposits/create', 'DepositController@create')->name('deposits.create');
        Route::get('user/deposits/{deposit}/complete', 'DepositController@complete')->name('deposits.complete');
        Route::patch('user/deposits/methods/{depositMethod}/{deposit}', 'DepositController@update')->name('deposits.update')->middleware('concurrent');
        Route::post('user/deposits/methods/{depositMethod}', 'DepositController@store')->name('deposits.store')->middleware('concurrent');

        // withdrawals
        Route::get('user/withdrawals', 'WithdrawalController@index')->name('withdrawals.index');
        Route::get('user/withdrawals/create', 'WithdrawalController@create')->name('withdrawals.create');
        Route::post('user/withdrawals/methods/{withdrawalMethod}', 'WithdrawalController@store')->name('withdrawals.store')->middleware('concurrent');

        // ethereum
        Route::get('ethereum/addresses', 'EthereumController@index');
        Route::post('ethereum/addresses', 'EthereumController@store');
        Route::post('ethereum/addresses/{ethereumAddress}/verify', 'EthereumController@verify');
        // bsc
        Route::get('bsc/addresses', 'BscController@index');
        Route::post('bsc/addresses', 'BscController@store');
        Route::post('bsc/addresses/{bscAddress}/verify', 'BscController@verify');
    });

// backend
Route::prefix('admin')
    ->name('backend.')
    ->namespace('Packages\Payments\Http\Controllers\Backend')
    ->middleware(['web', 'auth', 'active', 'email_verified', '2fa', 'role:' . App\Models\User::ROLE_ADMIN]) // it's important to add web middleware as it's not automatically added for packages routes
    ->group(function () {
        // dashboard
        Route::get('dashboard/payments', 'DashboardController@payments')->name('dashboard.payments');
        // deposits
        Route::resource('deposits', 'DepositController',  ['only' => ['index', 'show']]);
        Route::get('deposits/{deposit}/transaction', 'DepositController@transaction')->name('deposits.transaction');
        Route::post('deposits/{deposit}/cancel', 'DepositController@cancel')->name('deposits.cancel');
        Route::post('deposits/{deposit}/complete', 'DepositController@complete')->name('deposits.complete');
        // withdrawals
        Route::resource('withdrawals', 'WithdrawalController',  ['only' => ['index','show','update']]);
        Route::get('withdrawals/{withdrawal}/transaction', 'WithdrawalController@transaction')->name('withdrawals.transaction');
        Route::post('withdrawals/{withdrawal}/send', 'WithdrawalController@send')->name('withdrawals.send');
        Route::post('withdrawals/{withdrawal}/cancel', 'WithdrawalController@cancel')->name('withdrawals.cancel');
        Route::post('withdrawals/{withdrawal}/complete', 'WithdrawalController@complete')->name('withdrawals.complete');
        // payment gateways
        Route::resource('payment-gateways', 'PaymentGatewayController', ['only' => ['index','edit','update']]);
        Route::get('payment-gateways/{paymentGateway}/info', 'PaymentGatewayController@info')->name('payment-gateways.info');
        Route::get('payment-gateways/{paymentGateway}/balance', 'PaymentGatewayController@balance')->name('payment-gateways.balance');
        // deposit methods
        Route::resource('deposit-methods', 'DepositMethodController', ['only' => ['index','create','store','edit','update','destroy']]);
        Route::get('deposit-methods/{deposit_method}/delete', 'DepositMethodController@delete')->name('deposit-methods.delete');
        // withdrawal methods
        Route::resource('withdrawal-methods', 'WithdrawalMethodController', ['only' => ['index','create','store','edit','update','destroy']]);
        Route::get('withdrawal-methods/{withdrawal_method}/delete', 'WithdrawalMethodController@delete')->name('withdrawal-methods.delete');
    });

// Web hooks
Route::name('payments.')
    ->namespace('Packages\Payments\Http\Controllers\Frontend')
    ->middleware('web') // it's important to add web middleware as it's not automatically added for packages routes
    ->group(function () {
        // these URIs should also be added to exceptions in VerifyCsrfToken class, so that CSRF validations are not run
        Route::get('webhooks/{paymentGateway}/complete', 'WebhookController@completePayment')->name('webhooks.complete');
        Route::post('webhooks/{paymentGateway}/ipn', 'WebhookController@ipn')->name('webhooks.ipn');
    });
