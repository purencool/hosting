<?php

namespace Tests\Unit;

use App\Services\AppConfigurationCreators\NginxConfigGenerator;
use Tests\TestCase;

class NginxConfigGeneratorTest extends TestCase
{
    /** @test */
    public function it_generates_config_for_multiple_server_names()
    {
        $serverNames = ['houses.cfapp', 'hotels.cfapp'];
        $generator = new NginxConfigGenerator($serverNames);
        $config = $generator->generateConfig();

        $this->assertCount(2, $config);

        foreach ($config as $i => $block) {
            $expectedServerName = $serverNames[$i];
            $this->assertEquals($expectedServerName, $block['server_name']);
            $this->assertEquals("http://{$expectedServerName}_", $block['proxy_pass']);
        }
    }

    /** @test */
    public function it_generates_config_for_empty_server_names_array()
    {
        $generator = new NginxConfigGenerator([]);
        $config = $generator->generateConfig();

        $this->assertCount(0, $config);
    }
}
