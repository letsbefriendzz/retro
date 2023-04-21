<?php

namespace App\Http\Controllers;

use App\Events\RetroNoteCreated;
use App\Events\RetroNoteDeleted;
use App\Http\Requests\RetroNoteRequest;
use App\Http\Resources\RetroNoteResource;
use App\Models\RetroNote;
use Illuminate\Http\JsonResponse;

class RetroNoteController extends Controller
{
    public function store(RetroNoteRequest $request): RetroNoteResource
    {
        $validated = $request->validated();
        $retroNote = RetroNote::query()->create([
            'retro_session_id' => $validated['retro_session_id'],
            'retro_user_id' => $validated['retro_user_id'],
            'retro_column' => $validated['retro_column'],
            'content' => $validated['content'],
        ]);

        RetroNoteCreated::dispatch($validated['retro_session_id'], $retroNote);

        return new RetroNoteResource($retroNote);
    }

    public function show(RetroNote $retroNote): RetroNoteResource
    {
        return new RetroNoteResource($retroNote);
    }

    public function update(RetroNote $retroNote, RetroNoteRequest $request): RetroNoteResource
    {
        $validated = $request->validated();

        $retroNote->update([
            'content' => $validated['content'],
        ]);

        return new RetroNoteResource($retroNote);
    }

    public function destroy(RetroNote $retroNote): JsonResponse
    {
        $retroSession = $retroNote->retroSession;
        $delete = $retroNote->delete();

        if (!$delete) {
            return response()->json([], 422);
        }

        RetroNoteDeleted::dispatch($retroSession->id, $retroNote->id);

        return response()->json([
            'deleted' => $delete,
            'retroNote' => new RetroNoteResource($retroNote),
        ]);
    }
}
