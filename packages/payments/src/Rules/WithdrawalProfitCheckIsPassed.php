<?php

namespace Packages\Payments\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Packages\Payments\Models\Deposit;
use Packages\Payments\Models\Withdrawal;

class WithdrawalProfitCheckIsPassed implements Rule
{
    private $user;
    private $validationEnabled;
    private $maxWithdrawalAmount;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->validationEnabled = config('payments.withdrawal_only_profits');
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $amount
     * @return bool
     */
    public function passes($attribute, $amount)
    {
        if ($this->validationEnabled) {
            $totalDepositsAmount = (float) $this->user->account->related(Deposit::class)->where('status', Deposit::STATUS_COMPLETED)->sum('amount');
            $totalWithdrawalsAmount = (float) $this->user->account->related(Withdrawal::class)->where('status', '!=', Withdrawal::STATUS_CANCELLED)->sum('amount');
            $totalGamesProfit = (float) $this->user->account->games()->select(DB::raw('SUM(GREATEST(win - bet, 0)) AS total_profit'))->value('total_profit');

            $this->maxWithdrawalAmount = max(0, $totalDepositsAmount + $totalGamesProfit - $totalWithdrawalsAmount);

            $result = $amount <= $this->maxWithdrawalAmount;
        } else {
            $result = TRUE;
        }

        return $result;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('Maximum allowed withdrawal is :n credits.', ['n' => $this->maxWithdrawalAmount]);
    }
}
