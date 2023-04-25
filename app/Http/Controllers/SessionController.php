<?php

namespace App\Http\Controllers;

use App\Http\Resources\ColumnResource;
use App\Http\Resources\SessionResource;
use App\Http\Resources\UserResource;
use App\Models\Session;
use Inertia\Inertia;
use Inertia\Response;

class SessionController extends Controller
{
    public function show(string $sessionSlug): Response
    {
        /**
         *  TODO: refactor this into something prettier.
         *  While it does function, using first and then checking the falsiness of the
         *  session that is returned is diddly darn ugly, if I do say so myself.
         */
        $session = Session::query()->with('notes')
            ->where('slug', $sessionSlug)
            ->first();

        if (!$session) {
            $session = Session::query()->create([
                'slug' => $sessionSlug
            ]);

            $session->createDefaultColumns();
        }

        $session->notes = collect($session->notes)->map(function ($note) {
            $note = $note->toArray();
            return [
                "id" => $note['id'],
                "content" => $note['content'],
                "column_id" => $note['column_id'],
            ];
        });

        $renderData = [
            'session' => (new SessionResource($session)),
            'notes' => $session->notes, // todo NotesResource
            'user' => (new UserResource(auth()->user())),
            'columns' => ColumnResource::collection($session->columns)->collection,
        ];

        return Inertia::render('RetroBoard/RetroBoardParent', $renderData);
    }
}
