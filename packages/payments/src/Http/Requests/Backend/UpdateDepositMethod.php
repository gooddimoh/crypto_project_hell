<?php

namespace Packages\Payments\Http\Requests\Backend;

use App\Rules\ConfigVariablesAreSet;
use App\Rules\PhpExtensionIsInstalled;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDepositMethod extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|max:100',
            'enabled' => ['required']
        ];

        if ($this->deposit_method->code == 'paypal' && $this->enabled) {
            $rules['enabled'] = array_merge($rules['enabled'], [
                new ConfigVariablesAreSet([
                    'payments.paypal.user',
                    'payments.paypal.password',
                    'payments.paypal.signature',
                ])
            ]);
        } elseif ($this->deposit_method->code == 'stripe' && $this->enabled) {
            $rules['enabled'] = array_merge($rules['enabled'], [
                new ConfigVariablesAreSet([
                    'payments.stripe.public_key',
                    'payments.stripe.secret_key',
                ])
            ]);
        } elseif ($this->deposit_method->code == 'coinpayments' && $this->enabled) {
            $rules['enabled'] = array_merge($rules['enabled'], [
                new ConfigVariablesAreSet([
                    'payments.coinpayments.merchant_id',
                    'payments.coinpayments.public_key',
                    'payments.coinpayments.private_key',
                    'payments.coinpayments.secret_key',
                ])
            ]);
        } elseif ($this->deposit_method->code == 'metamask' && $this->enabled) {
            $rules['enabled'] = array_merge($rules['enabled'], [
                new PhpExtensionIsInstalled('gmp'),
                new ConfigVariablesAreSet([
                    'payments.ethereum.api_key',
                    'payments.ethereum.deposit_address',
                ])
            ]);
        } elseif ($this->deposit_method->code == 'bsc' && $this->enabled) {
            $rules['enabled'] = array_merge($rules['enabled'], [
                new PhpExtensionIsInstalled('gmp'),
                new ConfigVariablesAreSet([
                    'payments.bsc.api_key',
                    'payments.bsc.deposit_address',
                ])
            ]);
        }

        return $rules;
    }
}
