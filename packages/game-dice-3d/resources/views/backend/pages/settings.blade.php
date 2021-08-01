<div class="card border-primary">
    <div class="card-header border-primary">
        <h5 class="mb-0">
            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tab-game-dice-3d" aria-expanded="true">
                {{ __('Game: :game', ['game' => __('Dice 3D')]) }}
            </button>
        </h5>
    </div>
    <div id="tab-game-dice-3d" class="collapse">
        <div class="card-body">
            <div class="form-group">
                <label>{{ __('Categories') }}</label>
                <input type="text" name="GAME_DICE_3D_CATEGORIES" class="form-control" value="{{ config('game-dice-3d.categories') }}">
                <small>{{ __('Comma-delimited list') }}</small>
            </div>
            <file-upload
                label="{{ __('Banner') }}"
                path="{{ config('game-dice-3d.banner') }}"
                name="GAME_DICE_3D_BANNER"
                file-name="dice-3d"
                folder="home"
            ></file-upload>
            <div class="form-group">
                <label>{{ __('Min bet') }}</label>
                <input type="number" name="GAME_DICE_3D_MIN_BET" class="form-control" value="{{ config('game-dice-3d.min_bet') }}">
            </div>
            <div class="form-group">
                <label>{{ __('Max bet') }}</label>
                <input type="number" name="GAME_DICE_3D_MAX_BET" class="form-control" value="{{ config('game-dice-3d.max_bet') }}">
            </div>
            <div class="form-group">
                <label>{{ __('Bet increment / decrement amount') }}</label>
                <input type="number" name="GAME_DICE_3D_BET_CHANGE_AMOUNT" class="form-control" value="{{ config('game-dice-3d.bet_change_amount') }}">
            </div>
            <div class="form-group">
                <label>{{ __('Default bet amount') }}</label>
                <input type="number" name="GAME_DICE_3D_DEFAULT_BET_AMOUNT" class="form-control" value="{{ config('game-dice-3d.default_bet_amount') }}">
            </div>
            <div class="form-group">
                <label>{{ __('House edge') }}</label>
                <div class="input-group">
                    <input type="number" name="GAME_DICE_3D_HOUSE_EDGE" class="form-control" value="{{ config('game-dice-3d.house_edge') }}">
                    <div class="input-group-append">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>{{ __('Dice') }}</label>
                <select multiple name="GAME_DICE_3D_DICE[]" class="form-control">
                    @foreach(array_keys(config('game-dice-3d.dice_types')) as $die)
                        <option value="{{ $die }}" {{ in_array($die, config('game-dice-3d.dice')) ? 'selected' : '' }}>
                            {{ __(ucfirst($die)) }}
                        </option>
                    @endforeach
                </select>
                <small>
                    {{ __('Please use the CTRL key (PC) or COMMAND key (Mac) to select multiple items.') }}
                </small>
            </div>
        </div>
    </div>
</div>
