<?php

namespace Packages\Payments\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Packages\Payments\Rules\BscAddressBalanceIsSufficient;
use Packages\Payments\Rules\BscAddressConfirmed;
use Packages\Payments\Rules\EthereumAddressBalanceIsSufficient;
use Packages\Payments\Rules\EthereumAddressConfirmed;
use Packages\Payments\Services\MulticurrencyPaymentService;
use Packages\Payments\Services\PaymentService;

class StoreDeposit extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // given gateway exists and is active
        return $this->depositMethod->enabled;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            // note that amount is passed in payment currency, not credits
            'amount' => [
                'required',
                'integer',
                'min:'.config('payments.deposit_min'),
                'max:'.config('payments.deposit_max')
            ]
        ];

        if ($this->depositMethod->gateway) {
            $paymentService = PaymentService::createFromModel($this->depositMethod->gateway);

            // extra validation for multicurrency gateways (like coinpayments.net)
            if ($paymentService instanceof MulticurrencyPaymentService) {
                $paymentCurrencies = $paymentService->getPaymentCurrencies();
                $rules['payment_currency'] = 'required|in:' . $paymentCurrencies->keys()->implode(',');
            }
        }

        // add custom fields validation
        foreach ($this->depositMethod->parameters as $parameter) {
            if ($parameter->validation) {
                $rules['parameters.' . $parameter->id] = $parameter->validation;
            }
        }

        // extra validation for Metamask / Ethereum
        if ($this->depositMethod->code == 'metamask') {
            // check that ethereum address was confirmed
            $rules['parameters.address'] = [$rules['parameters.address'], new EthereumAddressConfirmed($this->user())];
            // check ethereum address balance
            $rules['amount'][] = new EthereumAddressBalanceIsSufficient($paymentService, $this->parameters['address']);
        }

        // extra validation for Metamask / Binance Smart Chain
        if ($this->depositMethod->code == 'bsc') {
            // check that ethereum address was confirmed
            $rules['parameters.address'] = [$rules['parameters.address'], new BscAddressConfirmed($this->user())];
            // check ethereum address balance
            $rules['amount'][] = new BscAddressBalanceIsSufficient($paymentService, $this->parameters['address']);
        }

        return $rules;
    }
}
