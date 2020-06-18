<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TeamCreateTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testCreatePass()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/teams/create')
                ->type('title', 'SampleTeam')
                ->press('Create')
                ->assertPathIs('/teams');
        });
    }

    public function testCreateFail()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/teams/create')
                ->type('title', '')
                ->press('Create')
                ->assertPathIs('/teams/create');
        });
    }
}
