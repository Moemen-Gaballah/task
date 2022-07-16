<?php

namespace App\Http\Requests;

use App\Rules\CardNumberValidation;
use App\Rules\ExpiryDateValidation;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            // todo change max 200 to 200 - transfer many in last hour
            'amount' => ['required', 'numeric', 'min:0', 'max:200'],
            'card_number' => ['required', new CardNumberValidation()],
            'name_on_card' => ['required','string'],
            'expiry_date' => ['required', new ExpiryDateValidation()],
            'cvv' => ['required','numeric', 'digits:3'],
        ];
    }
}
