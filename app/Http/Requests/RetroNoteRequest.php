<?php /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */

namespace App\Http\Requests;

use App\Models\RetroSession;
use Illuminate\Foundation\Http\FormRequest;

class RetroNoteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'retro_session_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!RetroSession::query()->find($value)) {
                        $fail('A RetroSession with the ID ' . $value . ' does not exist.');
                    }
                },
            ],
            'retro_user_id' => 'required',
            'retro_column' => 'required',
            'content' => 'required|max:255',
        ];
    }
}
