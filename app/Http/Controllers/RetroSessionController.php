<?php

namespace App\Http\Controllers;

use App\Models\RetroSession;
use App\Models\RetroUser;
use Illuminate\Http\JsonResponse;

class RetroSessionController extends Controller
{
    public function show(string $sessionSlug): JsonResponse
    {
        $retroSession = RetroSession::query()->create([
            'slug' => $sessionSlug,
        ]);

        $retroUser = RetroUser::factory()->create([ // todo refactor away from factories
            'retro_session_id' => $retroSession->id
        ]);

        return response()->json([
            'retroSession' => $retroSession,
            'retroUser' => $retroUser,
        ]);
    }
}
