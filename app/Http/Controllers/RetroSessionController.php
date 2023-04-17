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
        $retroSession = RetroSession::query()->with('retroNotes')->firstOrCreate([
            'slug' => $sessionSlug,
        ]);

        $retroUser = RetroUser::factory()->create([ // todo refactor away from factories
            'retro_session_id' => $retroSession->id
        ]);

        return Inertia::render('RetroBoard/RetroBoardParent', [
            'retroSession' => $retroSession,
            'retroNotes' => $retroSession->retroNotes,
            'retroUser' => $retroUser,
        ]);
    }
}
