<?php

namespace App\Http\Controllers;

use App\Events\ColumnCreated;
use App\Events\ColumnDeleted;
use App\Http\Requests\DestroyColumnRequest;
use App\Http\Requests\StoreColumnRequest;
use App\Http\Resources\ColumnResource;
use App\Models\Column;
use Illuminate\Http\JsonResponse;

class ColumnController extends Controller
{
    public function store(StoreColumnRequest $request): ColumnResource
    {
        // todo introduce constraint for columns with the same session_id and title
        $validated = $request->validated();

        $column = Column::query()->create([
            'title' => $validated['title'],
            'session_id' => $validated['session_id'],
        ]);

        ColumnCreated::dispatch($request->input('session_id'), $column);

        return new ColumnResource($column);
    }

    public function destroy(DestroyColumnRequest $request, int $columnId): JsonResponse
    {
        $validated = $request->validated();

        $deleted = Column::query()->where('id', $columnId)->delete();

        if ($deleted) {
            ColumnDeleted::dispatch($validated['session_id'], $columnId);
        }

        return response()->json([
            'deleted' => $deleted,
        ]);
    }
}
