<?php

namespace Packages\Payments\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Packages\Payments\Models\BscAddress;

class VerifyBscAddress extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->bscAddress instanceof BscAddress && !$this->bscAddress->confirmed;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'signature' => 'required|min:100|max:150'
        ];
    }
}
