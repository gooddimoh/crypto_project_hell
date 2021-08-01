<?php

namespace Packages\GameDice3D\Services;

use App\Helpers\Games\NumberGenerator;
use App\Services\GameService;
use Illuminate\Database\Eloquent\Model;
use Packages\GameDice3D\Models\GameDice3D;

class GameDice3DService extends GameService
{
    protected $gameableModel = GameDice3D::class;

    private $numberGenerator;

    public function __construct($user = NULL)
    {
        parent::__construct($user);

        $this->numberGenerator = new NumberGenerator(self::calcMinRoll(), self::calcMaxRoll());
    }

    protected function createGameable(): Model
    {
        $gameable = new GameDice3D();
        $gameable->save();

        return $gameable;
    }

    protected function makeSecret(): string
    {
        return $this->numberGenerator->generate()->getNumber();
    }

    protected function adjustSecret(): string
    {
        return $this->numberGenerator->shift($this->game->shift_value)->getNumber();
    }

    /**
     * Play roulette
     *
     * @param $params
     */
    public function play($params): GameService
    {
        if (!$this->game->gameable)
            throw new \Exception('Gameable model should be loaded first.');

        $direction = $params['direction'];
        $bet = $params['bet'];
        $refNumber = $params['ref_number'];

        // load initial roulette position
        $this->numberGenerator->setNumber($this->game->secret);

        $this->game->gameable->direction = $direction;
        $this->game->gameable->win_chance = $this->calcWinChance($direction, $refNumber);
        $this->game->gameable->payout = $this->calcPayout($this->game->gameable->win_chance);
        $this->game->gameable->ref_number = $refNumber;
        $this->game->gameable->roll = $this->adjustSecret(); // shift result number by another random result

        $win = ($direction < 0 && $this->game->gameable->roll < $this->game->gameable->ref_number) || ($direction > 0 && $this->game->gameable->roll >= $this->game->gameable->ref_number) ?
            round($bet * $this->game->gameable->payout, 2) : 0;

        // complete the game
        $this->complete($bet, $win);

        return $this;
    }

    public static function calcMinRoll(): int
    {
        return count(config('game-dice-3d.dice'));
    }

    public static function calcMaxRoll(): int
    {
        return array_reduce(config('game-dice-3d.dice'), function ($carry, $id) {
            $carry += config('game-dice-3d.dice_types')[$id]['max'];
            return $carry;
        }, 0);
    }

    public static function calcMinRefNumber(): int
    {
        return self::calcMinRoll() + 1;
    }

    public static function calcMaxRefNumber(): int
    {
        return self::calcMaxRoll();
    }

    private function calcWinChance(int $direction, int $refNumber): float
    {
        $base = self::calcMaxRoll() - self::calcMinRoll() + 1;

        $winChance = $direction < 0
            ? ($refNumber - self::calcMinRoll()) / $base * 100
            : (self::calcMaxRoll() - $refNumber + 1) / $base * 100;

        return round($winChance, 2);
    }

    private function calcPayout(float $winChance): float
    {
        return round((100 - config('game-dice-3d.house_edge')) / $winChance, 4);
    }
}
