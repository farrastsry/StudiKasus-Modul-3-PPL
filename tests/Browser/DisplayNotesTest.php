<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Note;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DisplayNotesTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testDisplayNotes(): void
    {
        $user = User::factory()->create();

        $note = Note::factory()->create([
            'penulis_id'     => $user->id,
            'title'       => 'NoteShow',
            'description' => 'Lorem ipsum dolor amet.',
        ]);

        $this->browse(function (Browser $browser) use ($user, $note) {
            $browser->loginAs($user)
                    ->visit('/notes')
                    ->clickLink('NoteShow')
                    ->assertPathIs("/note/{$note->id}")
                    ->assertSee('NoteShow')
                    ->assertSee('Lorem ipsum dolor amet.');
        });
    }
}
