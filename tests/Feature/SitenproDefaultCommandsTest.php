<?php

namespace Tests\Feature;


use Tests\TestCase;

/**
 *
 */
class SitenproDefaultCommandsTest extends TestCase
{
    /** @test */
    public function it_displays_the_welcome_message()
    {
        $this->artisan('spro:help')
            ->expectsOutput('-------------------------------------')
            ->expectsOutput('Sitenpro Help')
            ->expectsOutput('-------------------------------------')
            ->expectsOutput('Available commands:')
            ->expectsOutput('Sitenpro:help  Show this help message')
            ->expectsOutput('-------------------------------------')
            ->assertExitCode(0);

    }
}
