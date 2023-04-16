<?php

namespace App\Http\Controllers;

use App\Models\RetroSession;
use Illuminate\Http\JsonResponse;

class RetroSessionController extends Controller
{
    public function show(string $sessionSlug): JsonResponse
    {
        $retroSession = RetroSession::query()->create([
            'slug' => $sessionSlug,
        ]);
        return response()->json(['retroSession' => $retroSession]);
    }
}
