<?php

namespace App\Http\Requests;

use App\Models\Column;
use App\Models\Session;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class StoreColumnRequest extends FormRequest
{
    public function rules(): array
    {
        $title = $this->input('title');
        return [
            'title' => 'required',
            'session_id' => [
                'required',
                function ($attribute, $value, $fail) use ($title) {
                    if (!Session::query()->find($value)) {
                        $fail('A Session with the ID ' . $value . ' does not exist.');
                    }

                    if (Column::query()->where('title', $title)->where('session_id', $value)->exists()) {
                        $fail('A column with the title ' . $title . ' already exists in session #' . $value . '.');
                    }
                },
            ]
        ];
    }

    // todo determine if this is good or not
    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse([
            'message' => 'The given data was invalid.',
            'errors' => $validator->errors(),
        ], 422);

        throw new ValidationException($validator, $response);
    }
}
