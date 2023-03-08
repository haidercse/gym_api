<?php

namespace App\Http\Requests;

use App\Services\ResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class MemberStoreRequest extends FormRequest
{
    use ResponseTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:50',
            'gender' => 'required',
            'mobile_number' => 'required|unique:members,mobile_number|max:11',
            'address' => 'nullable',
            'image' => 'required',
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d',
        ];
    }

   
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->errorResponse((new ValidationException($validator))->errors())
        );
    }
}
