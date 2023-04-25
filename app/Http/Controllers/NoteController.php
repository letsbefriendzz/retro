<?php

namespace App\Http\Controllers;

use App\Events\NoteCreated;
use App\Events\NoteDeleted;
use App\Http\Requests\UpdateNoteRequest;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Http\JsonResponse;

class NoteController extends Controller
{
    public function store(StoreNoteRequest $request): NoteResource
    {
        $validated = $request->validated();
        $note = Note::query()->create([
            'session_id' => $validated['session_id'],
            'column_id' => $validated['column_id'],
            'content' => $validated['content'],
        ]);

        NoteCreated::dispatch($validated['session_id'], $note);

        return new NoteResource($note);
    }

    public function show(Note $note): NoteResource
    {
        return new NoteResource($note);
    }

    public function update(Note $note, UpdateNoteRequest $request): NoteResource
    {
        $validated = $request->validated();

        $note->update([
            'content' => $validated['content'],
        ]);

        return new NoteResource($note);
    }

    public function destroy(Note $note): JsonResponse
    {
        $session = $note->session;
        $delete = $note->delete();

        if (!$delete) {
            return response()->json([], 422);
        }

        NoteDeleted::dispatch($session->id, $note->id);

        return response()->json([
            'deleted' => $delete,
            'note' => new NoteResource($note),
        ]);
    }
}
