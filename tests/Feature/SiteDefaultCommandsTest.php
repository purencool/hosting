<?php

namespace Tests\Feature;


use Tests\TestCase;

/**
 *
 */
class SiteDefaultCommandsTest extends TestCase
{
    /** @test */
    public function it_displays_the_welcome_message()
    {
        $this->artisan('app:help')
            ->expectsOutput('-------------------------------------')
            ->expectsOutput('App Help')
            ->expectsOutput('-------------------------------------')
            ->expectsOutput('Available commands:')
            ->expectsOutput('app:help  Show this help message')
            ->expectsOutput('-------------------------------------')
            ->assertExitCode(0);

    }
}
