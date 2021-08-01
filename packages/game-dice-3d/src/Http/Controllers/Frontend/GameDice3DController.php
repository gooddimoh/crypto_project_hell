<?php

namespace Packages\GameDice3D\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Packages\GameDice3D\Http\Requests\Frontend\Play;
use Packages\GameDice3D\Services\GameDice3DService;

class GameDice3DController extends Controller
{
    public function show(GameDice3DService $gameDiceService)
    {
        $game = $gameDiceService->init()->get();
        $game->loadMissing('account');

        return view('game-dice-3d::frontend.pages.game', [
            'options' => [
                'game' => $game,
                'preloaderImgUrl' => asset('images/preloader/' . config('settings.theme') . '/preloader.svg'),
                'theme' => config('settings.theme'),
                'config' => [
                    'minBet'            => config('game-dice-3d.min_bet'),
                    'maxBet'            => config('game-dice-3d.max_bet'),
                    'betChangeAmount'   => config('game-dice-3d.bet_change_amount'),
                    'defaultBetAmount'  => config('game-dice-3d.default_bet_amount'),
                    'houseEdge'         => config('game-dice-3d.house_edge'),
                    'dice_types'        => config('game-dice-3d.dice_types'),
                    'dice'              => config('game-dice-3d.dice'),
                ],
                'routes' => [
                    'play' => route('games.dice-3d.play'),
                ],
                'sounds' => [
                    'click'     => asset('audio/games/dice-3d/click.wav'),
                    'bet'       => asset('audio/games/dice-3d/bet.wav'),
                    'lose'      => asset('audio/games/dice-3d/lose.wav'),
                    'win'       => asset('audio/games/dice-3d/win.wav'),
                    'roll1'     => asset('audio/games/dice-3d/roll1.wav'),
                    'roll2'     => asset('audio/games/dice-3d/roll2.wav'),
                    'blocked'   => asset('audio/games/dice-3d/blocked.wav')
                ]
            ]
        ]);
    }

    /**
     * Draw cards
     *
     * @param Play $request
     * @param GameDice3DService $gameDiceService
     * @return mixed
     */
    public function play(Play $request, GameDice3DService $gameDiceService)
    {
        return $gameDiceService
            ->load($request->game_id)
            ->setGameProperty('client_seed', $request->seed)
            ->play($request->only(['bet', 'direction', 'ref_number']))
            ->get();
    }
}
