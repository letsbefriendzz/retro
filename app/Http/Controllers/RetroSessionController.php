<?php

namespace App\Http\Controllers;

use App\Models\RetroSession;
use Inertia\Inertia;
use Inertia\Response;

class RetroSessionController extends Controller
{
    public function show(string $sessionSlug): Response
    {
        $retroSession = RetroSession::query()->with('retroNotes')
            ->firstOrCreate([
                'slug' => $sessionSlug,
            ]);

        $retroSession->retroNotes = collect($retroSession->retroNotes)->map(function ($note) {
            $note = $note->toArray();
            return [
                "id" => $note['id'],
                "content" => $note['content'],
                "retro_column" => $note['retro_column'],
                "retro_session_id" => $note['retro_session_id'],
                "created_at" => $note['created_at'],
                "updated_at" => $note['updated_at'],
            ];
        });

        return Inertia::render('RetroBoard/RetroBoardParent', [
            'retroSession' => $retroSession,
            'retroNotes' => $retroSession->retroNotes,
        ]);
    }
}
