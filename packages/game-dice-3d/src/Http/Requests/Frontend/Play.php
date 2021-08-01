<?php

namespace Packages\GameDice3D\Http\Requests\Frontend;

use App\Models\Game;
use App\Rules\BalanceIsSufficient;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Packages\GameDice3D\Models\GameDice3D;
use Packages\GameDice3D\Services\GameDice3DService;

class Play extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->game_id) {
            $game = Game::find($this->game_id);
            return $game && $game->gameable_type == GameDice3D::class && $game->account->user_id == $this->user()->id && $game->status == Game::STATUS_CREATED;
        }

        return FALSE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'game_id'   => 'required|integer',
            'direction' => 'required|in:-1,1',
            'bet'       => [
                'required',
                'integer',
                'min:' . config('game-dice-3d.min_bet'),
                'max:' . config('game-dice-3d.max_bet'),
                new BalanceIsSufficient($request->bet)
            ],
            'ref_number' => 'required|integer|min:' . GameDice3DService::calcMinRefNumber() . '|max:' . GameDice3DService::calcMaxRefNumber(),
        ];
    }
}
