<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Session;
use Inertia\Inertia;
use Inertia\Response;

class SessionController extends Controller
{
    public function show(string $sessionSlug): Response
    {
        /** TODO: refactor this into something prettier.
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
                "retro_column" => $note['retro_column'],
                "session_id" => $note['session_id'],
                "created_at" => $note['created_at'],
                "updated_at" => $note['updated_at'],
            ];
        });

        return Inertia::render('RetroBoard/RetroBoardParent', [
            'session' => $session,
            'notes' => $session->notes,
            'user' => (new UserResource(auth()->user()))->toArray(null), // todo not call ->toArray() directly
        ]);
    }
}
