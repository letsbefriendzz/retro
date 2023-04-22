<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Inertia\Inertia;
use Inertia\Response;

class SessionController extends Controller
{
    public function show(string $sessionSlug): Response
    {
        $session = Session::query()->with('notes')
            ->firstOrCreate([
                'slug' => $sessionSlug,
            ]);

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
            'notes' => $session->notes, // todo fe refactor
        ]);
    }
}
