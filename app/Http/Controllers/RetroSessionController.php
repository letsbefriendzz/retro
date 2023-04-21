<?php

namespace App\Http\Controllers;

use App\Models\RetroSession;
use App\Models\RetroUser;
use Inertia\Inertia;
use Inertia\Response;

class RetroSessionController extends Controller
{
    public function show(string $sessionSlug): Response
    {
        $retroSession = RetroSession::query()->with('retroNotes')
            ->with(['retroNotes.retroUser' => function ($query) {
                $query->select('id', 'colour');
            }])
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
                "retro_user_id" => $note['retro_user_id'],
                "created_at" => $note['created_at'],
                "updated_at" => $note['updated_at'],
                "colour" => $note['retro_user']['colour'],
            ];
        });

        $retroUser = RetroUser::query()->create([
            'retro_session_id' => $retroSession->id,
            'name' => 'retro_user',
            'colour' => collect($retroSession->unusedColours())->count() > 0 ? collect($retroSession->unusedColours())->random() : 'base-100', // todo: not this
        ]);

        return Inertia::render('RetroBoard/RetroBoardParent', [
            'retroSession' => $retroSession,
            'retroNotes' => $retroSession->retroNotes,
            'retroUser' => $retroUser,
        ]);
    }
}
