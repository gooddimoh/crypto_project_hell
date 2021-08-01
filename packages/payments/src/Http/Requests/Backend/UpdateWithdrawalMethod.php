<?php

namespace Packages\Payments\Http\Requests\Backend;

use App\Rules\ConfigVariablesAreSet;
use Illuminate\Foundation\Http\FormRequest;

class UpdateWithdrawalMethod extends FormRequest
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

        if ($this->withdrawal_method->code == 'coinpayments' && $this->enabled) {
            $rules['enabled'] = array_merge($rules['enabled'], [
                new ConfigVariablesAreSet([
                    'payments.coinpayments.merchant_id',
                    'payments.coinpayments.public_key',
                    'payments.coinpayments.private_key',
                    'payments.coinpayments.secret_key',
                ])
            ]);
        }

        return $rules;
    }
}
