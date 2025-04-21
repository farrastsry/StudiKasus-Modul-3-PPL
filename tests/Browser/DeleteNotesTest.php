<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Note;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DeleteNotesTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testDeleteNote(): void
    {
        $user = User::factory()->create();

        $note = Note::factory()->create([
            'penulis_id'     => $user->id,
            'title'       => 'DeleteNote',
            'description' => 'This will be deleted.',
        ]);

        $this->browse(function (Browser $browser) use ($user, $note) {
            $browser->loginAs($user)
                    ->visit('/notes')
                    ->with(".note-card-{$note->id}", function ($card) {
                        $card->press('Delete');
                    })
                    ->assertSee('DeleteNote')
                    ->assertDontSee('DeleteNote');
        });
    }
}