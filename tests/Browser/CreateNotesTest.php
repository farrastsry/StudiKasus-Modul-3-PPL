<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateNotesTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateNotes(): void
    {
        $user = User::factory()->create([
            'email'    => 'noteuser@gmail.com',
            'password' => bcrypt('secret123'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/dashboard')
                    ->clickLink('Notes')
                    ->assertPathIs('/notes')
                    ->clickLink('Create Note')
                    ->assertPathIs('/create-note')
                    ->assertVisible('input[name="Title"]')
                    ->assertVisible('textarea[name="Description"]')
                    ->type('title', 'test1')
                    ->type('description', 'content')
                    ->press('CREATE')
                    ->assertPathIs('/notes')
                    ->assertSee('test1');
        });
    }
}
