<?php

namespace Packages\Payments\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class StoreBscAddress extends FormRequest
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
        return [
            'address' => 'required|size:42'
        ];
    }
}
