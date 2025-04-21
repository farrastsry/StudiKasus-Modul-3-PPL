<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testRegister(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->waitForLink('Register')
                    ->clickLink('Register')
                    ->assertPathIs('/register')
                    ->waitFor('input[name="Name"]')
                    ->type('name', 'Tester2')
                    ->type('email', 'test2@gmail.com')
                    ->type('password', 'secret123')
                    ->type('confirm password', 'secret123')
                    ->press('REGISTER')
                    ->assertPathIs('/dashboard')
                    ->assertSee('Dashboard');
        });
    }
}
