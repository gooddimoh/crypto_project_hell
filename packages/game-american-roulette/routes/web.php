<?php

// game routes
Route::name('games.')
    ->namespace('Packages\GameAmericanRoulette\Http\Controllers\Frontend')
    ->middleware(['web', 'auth', 'active', 'email_verified', '2fa']) // it's important to add web middleware as it's not automatically added for packages routes
    ->group(function () {
        // show initial game screen
        Route::get('games/american-roulette', 'GameAmericanRouletteController@show')->name('american-roulette.show');
        // play game
        Route::post('games/american-roulette/play', 'GameAmericanRouletteController@play')->name('american-roulette.play')->middleware('concurrent');
    });
