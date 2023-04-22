<?php

namespace Tests\Feature\Models;

use App\Models\Note;
use App\Models\Session;
use Tests\TestCase;

class SessionTest extends TestCase
{
    public function test_it_has_many_notes()
    {
        $session = Session::factory()->create();
        $note1 = Note::factory()->create([
            'session_id' => $session->id,
        ]);
        $note2 = Note::factory()->create([
            'session_id' => $session->id,
        ]);

        $this->assertCount(2, $session->fresh()->notes);
        $this->assertTrue($session->notes->contains($note1));
        $this->assertTrue($session->notes->contains($note2));
    }
}
