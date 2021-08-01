<?php

return [
    'version'               => '1.3.2',
    'min_bet'               => env('GAME_BLACKJACK_MIN_BET', 1),
    'max_bet'               => env('GAME_BLACKJACK_MAX_BET', 50),
    'bet_change_amount'     => env('GAME_BLACKJACK_BET_CHANGE_AMOUNT', 1),
    'default_bet_amount'    => env('GAME_BLACKJACK_DEFAULT_BET_AMOUNT', 1), // how much in credits to bet
    'banner'                => env('GAME_BLACKJACK_BANNER', '/images/home/blackjack.jpg'),
    'categories'            => env('GAME_BLACKJACK_CATEGORIES', 'Cards'),
];
