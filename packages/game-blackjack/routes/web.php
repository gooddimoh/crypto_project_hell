<?php

// game routes
Route::name('games.')
    ->namespace('Packages\GameBlackjack\Http\Controllers\Frontend')
    ->middleware(['web', 'auth', 'active', 'email_verified', '2fa']) // it's important to add web middleware as it's not automatically added for packages routes
    ->group(function () {
        // show initial game screen
        Route::get('games/blackjack', 'GameBlackjackController@show')->name('blackjack.show');
        // play game
        Route::post('games/blackjack/deal', 'GameBlackjackController@deal')->name('blackjack.deal')->middleware('concurrent');
        Route::post('games/blackjack/insurance', 'GameBlackjackController@insurance')->name('blackjack.insurance')->middleware('concurrent');
        Route::post('games/blackjack/hit', 'GameBlackjackController@hit')->name('blackjack.hit')->middleware('concurrent');
        Route::post('games/blackjack/double', 'GameBlackjackController@double')->name('blackjack.double')->middleware('concurrent');
        Route::post('games/blackjack/stand', 'GameBlackjackController@stand')->name('blackjack.stand')->middleware('concurrent');
        Route::post('games/blackjack/split', 'GameBlackjackController@split')->name('blackjack.split')->middleware('concurrent');
        Route::post('games/blackjack/split-hit', 'GameBlackjackController@splitHit')->name('blackjack.split-hit')->middleware('concurrent');
        Route::post('games/blackjack/split-stand', 'GameBlackjackController@splitStand')->name('blackjack.split-stand')->middleware('concurrent');
    });
