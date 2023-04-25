<?php

namespace App\Http\Requests;

use App\Models\Session;
use Illuminate\Foundation\Http\FormRequest;

class StoreColumnRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required',
            'session_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Session::query()->find($value)) {
                        $fail('A Session with the ID ' . $value . ' does not exist.');
                    }
                },
            ]
        ];
    }
}
