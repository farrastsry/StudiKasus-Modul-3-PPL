<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LogoutTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testLogout(): void
    {
        $user = User::factory()->create([
            'name'     => 'TestDummy',
            'email'    => 'dummy@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/dashboard')
                    ->click('@user-dropdown')
                    ->clickLink('Log Out')
                    ->assertPathIs('/')
                    ->assertSee('Modul 3');
        });
    }
}