<?php

namespace App\Http\Controllers;

use App\Events\ColumnCreated;
use App\Events\ColumnDeleted;
use App\Http\Resources\ColumnResource;
use App\Models\Column;
use App\Models\Session;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ColumnController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @throws AuthenticationException
     */
    public function store(Request $request): ColumnResource
    {
        $this->authCheck();

        $validated = $request->validate([
            'title' => 'required',
            'session_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Session::query()->find($value)) {
                        $fail('A Session with the ID ' . $value . ' does not exist.');
                    }
                },
            ]
        ]);

        $column = Column::query()->create([
            'title' => $validated['title'],
            'session_id' => $validated['session_id'],
        ]);

        ColumnCreated::dispatch($request->input('session_id'), $column);

        return new ColumnResource($column);
    }

    /**
     * @throws AuthenticationException
     */
    public function destroy(Request $request, int $columnId): JsonResponse
    {
        $this->authCheck();

        $request->validate([
            'session_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Session::query()->find($value)) {
                        $fail('A Session with the ID ' . $value . ' does not exist.');
                    }
                },
            ]
        ]);

        $deleted = Column::query()->where('id', $columnId)->delete();

        if ($deleted) {
            ColumnDeleted::dispatch($request->input('session_id'), $columnId);
        }

        return response()->json([
            'deleted' => $deleted,
        ]);
    }

    /**
     * @throws AuthenticationException
     */
    private function authCheck()
    {
        if (!auth()->check()) {
            throw new AuthenticationException();
        }
    }
}
