<?php /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */

namespace App\Http\Requests;

use App\Models\Column;
use App\Models\Session;
use Illuminate\Foundation\Http\FormRequest;

class NoteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'session_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Session::query()->find($value)) { // todo refactor to ->where()->exists()
                        $fail('A Session with the ID ' . $value . ' does not exist.');
                    }
                },
            ],
            'column_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Column::query()->find($value)) {
                        $fail('A Session with the ID ' . $value . ' does not exist.');
                    }
                },
            ],
            'content' => 'required|max:255',
        ];
    }
}
