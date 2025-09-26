<?php

namespace Tests\Unit;

use App\Services\EnvironmentVariables;
use Tests\TestCase;

class EnvironmentVariablesTest extends TestCase
{
    /** @test */
    public function it_gets_the_hosting_site_default_directory()
    {
        $expected = "hosting";
        $this->assertEquals($expected,(new EnvironmentVariables())->getHostingSiteBaseDirectory());
    }

    /** @test */
    public function it_gets_the_hosting_site_default_directory_path()
    {
        $expected = app_path("/../../hosting");
        $this->assertEquals($expected,(new EnvironmentVariables())->getHostingSiteBaseDirectoryPath());
    }

    /** @test */
    public function it_gets_hosting_site_environments()
    {
        $expected="dev,staging,editorial,production";
        $this->assertEquals($expected, (new EnvironmentVariables())->getHostingSiteEnvironments());
    }

    /** @test */
    public function it_gets_default_domain()
    {
        $expected = "debian";
        $this->assertEquals($expected,(new EnvironmentVariables())->getHostingOS());
    }
}
