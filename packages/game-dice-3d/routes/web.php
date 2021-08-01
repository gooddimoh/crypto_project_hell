<?php

// game routes
Route::name('games.')
    ->namespace('Packages\GameDice3D\Http\Controllers\Frontend')
    ->middleware(['web', 'auth', 'active', 'email_verified', '2fa']) // it's important to add web middleware as it's not automatically added for packages routes
    ->group(function () {
        // show initial game screen
        Route::get('games/dice-3d', 'GameDice3DController@show')->name('dice-3d.show');
        // play game
        Route::post('games/dice-3d/play', 'GameDice3DController@play')->name('dice-3d.play')->middleware('concurrent');
    });
