<?php

namespace Packages\GameDice3D\Models;

use App\Models\Game;
use Illuminate\Database\Eloquent\Model;

class GameDice3D extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'game_dice_3d';

    /**
     * This format will be used when the model is serialized to an array or JSON.
     *
     * @var array
     */
    protected $casts = [
        'direction'     => 'integer',
        'win_chance'    => 'float',
        'payout'        => 'float',
        'roll'          => 'integer',
    ];

    public function game()
    {
        return $this->morphOne(Game::class, 'gameable');
    }

    /**
     * Format $gameable->result attribute
     *
     * @return string
     */
    public function getResultAttribute(): string
    {
        return $this->roll . ' (' . __('bet') . ' ' . ($this->direction < 0 ? '<' : '>=') . ' ' . $this->ref_number . ')';
    }
}
