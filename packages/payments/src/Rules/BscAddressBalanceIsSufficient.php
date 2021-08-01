<?php

namespace Packages\Payments\Rules;

use Illuminate\Contracts\Validation\Rule;
use Packages\Payments\Helpers\Ethereum;
use Packages\Payments\Services\PaymentService;

class BscAddressBalanceIsSufficient implements Rule
{
    private $paymentService;
    private $address;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(PaymentService $paymentService, $address)
    {
        $this->paymentService = $paymentService;
        $this->address = $address;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!$this->address) {
            return FALSE;
        }

        $contractAddress = config('payments.bsc.deposit_contract');

        // if ERC20 token contract address is specified
        if ($contractAddress) {
            $this->paymentService->fetchTokenBalance($this->address, $contractAddress);
            $decimals = config('payments.bsc.deposit_contract_decimals');
        } else {
            $this->paymentService->fetchBalance($this->address);
            $decimals = 18;
        }

        // request is successful
        if ($this->paymentService->isResponseSuccessful()) {
            // get balance and convert it to an integer (it's provided as a string)
            $balance = $this->paymentService->getResponseData(); // string

            // convert balance to ETH / tokens, because it's provided in wei
            return Ethereum::fromWei($balance, $decimals) >= $value / $this->paymentService->getPaymentGatewayRate();
        }

        return FALSE;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('Insufficient balance to perform this operation.');
    }
}
