<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Note;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class EditNotesTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testEditNotes(): void
    {
        $user = User::factory()->create([
            'email'    => 'noteuser@gmail.com',
            'password' => bcrypt('secret123'),
            
        ]);
        
        $note = Note::factory()->create([
            'penulis_id'     => $user->id,
            'title'       => 'Old Title',
            'description' => 'Old content',
        ]);

        $this->browse(function (Browser $browser) use ($user, $note) {
            $browser->loginAs($user)
                    ->visit('/dashboard')
                    ->clickLink('Notes')
                    ->assertPathIs('/notes')
                    ->clickLink('Edit')
                    ->with(".note-card-{$note->id}", function ($card) {
                        $card->clickLink('Edit');
                    })
                    ->assertPathIs('/edit-note-page/{$note->id}')
                    ->type('title', 'updatetest1')
                    ->type('description', 'contentchange')
                    ->press('UPDATE')
                    ->assertPathIs('/notes')
                    ->assertSee('updatetest1');
        });
    }
}
