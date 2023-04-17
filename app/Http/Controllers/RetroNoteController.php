<?php

namespace App\Http\Controllers;

use App\Events\RetroNoteCreated;
use App\Http\Requests\RetroNoteRequest;
use App\Models\RetroNote;
use Illuminate\Http\JsonResponse;

class RetroNoteController extends Controller
{
    public function store(RetroNoteRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $retroNote = RetroNote::query()->create([
            'retro_session_id' => $validated['retro_session_id'],
            'content' => $validated['content'],
        ]);

        RetroNoteCreated::dispatch($validated['retro_session_id'], $retroNote);

        return response()->json([
            'retroNote' => $retroNote
        ]);
    }

    public function show(RetroNote $retroNote): JsonResponse
    {
        return response()->json(['retroNote' => $retroNote]);
    }

    public function update(RetroNote $retroNote, RetroNoteRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $retroNote->update([
            'content' => $validated['content'],
        ]);

        return response()->json([
            'retroNote' => $retroNote,
        ]);
    }

    public function destroy(RetroNote $retroNote): JsonResponse
    {
        $delete = $retroNote->delete();

        if (!$delete) {
            return response()->json([], 422);
        }

        return response()->json([
            'deleted' => $delete
        ]);
    }
}
