<?php

namespace Packages\Payments\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeposit extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // given deposit method exists and is active
        return $this->depositMethod->enabled
            && $this->depositMethod->id == $this->deposit->deposit_method_id
            && $this->deposit->is_created;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        if (in_array($this->depositMethod->code, ['metamask', 'bsc'])) {
            $rules['transaction_id'] = 'required|unique:deposits,external_id';
        }

        return $rules;
    }
}
