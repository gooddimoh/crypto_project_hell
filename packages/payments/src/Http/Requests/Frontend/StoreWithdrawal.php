<?php

namespace Packages\Payments\Http\Requests\Frontend;

use App\Rules\BalanceIsSufficient;
use Packages\Payments\Rules\DepositAmountIsSufficient;
use Packages\Payments\Rules\WithdrawalProfitCheckIsPassed;
use Packages\Payments\Services\CoinpaymentsPaymentService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Packages\Payments\Services\MulticurrencyPaymentService;
use Packages\Payments\Services\PaymentService;

class StoreWithdrawal extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // given withdrawal method exists and is active
        return $this->withdrawalMethod->enabled;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $rules = [
            'amount' => [
                'required',
                'numeric',
                'min:'.config('payments.withdrawal_min'),
                'max:'.config('payments.withdrawal_max'),
                new DepositAmountIsSufficient($request->user()),
                new BalanceIsSufficient($request->amount),
                new WithdrawalProfitCheckIsPassed($request->user())
            ],
            'parameters' => 'required|array'
        ];

        if ($this->withdrawalMethod->gateway) {
            // extra validation for multicurrency gateways (like coinpayments.net)
            $paymentService = PaymentService::createFromModel($this->withdrawalMethod->gateway);

            if ($paymentService instanceof MulticurrencyPaymentService) {
                $paymentCurrencies = $paymentService->getPaymentCurrencies();
                $rules['payment_currency'] = 'required|in:' . $paymentCurrencies->keys()->implode(',');
            }
        }

        // add custom fields validation
        foreach ($this->withdrawalMethod->parameters as $parameter) {
            if ($parameter->validation) {
                $rules['parameters.' . $parameter->id] = $parameter->validation;
            }
        }

        return $rules;
    }
}
