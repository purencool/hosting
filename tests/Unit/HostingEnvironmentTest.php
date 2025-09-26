<?php

namespace Tests\Unit;

use App\Services\AppDirectoryStructure\HostingEnvironment;
use Tests\TestCase;

class HostingEnvironmentTest extends TestCase
{

    /**
     * @var string
     */
    protected string $defaultPath = "";

    /**
     * @return void
     */
    protected function setUp(): void {
        parent::setUp();
        $this->defaultPath = app_path(
            "/../../". env('HOSTING_SITE_DEFAULT_PATH', 'default_path')
        );
    }
    /** @test */
    public function it_creates_a_base_app_directory()
    {
        $manager = new HostingEnvironment();
        $this->assertFalse(is_dir($this->defaultPath));
        $this->assertTrue($manager->createBaseDirectory());
        $this->assertTrue(is_dir($this->defaultPath));
    }

    /** @test */
    public function it_creates_environment_app_directories()
    {
        $manager = new HostingEnvironment();
        $this->assertTrue(is_dir($this->defaultPath));
        $this->assertTrue($manager->createEnvironmentDirectories());
    }

    /**
     * After all, the tests above have run destroy app.
     *
     * @test
     */
    public function it_uninstall_app_directories()
    {
        $manager = new HostingEnvironment();
        $this->assertTrue($manager->destroyEnvironmentDirectories());
        $this->assertTrue($manager->destroyBaseDirectory());
        $this->assertFalse(is_dir($this->defaultPath));
    }
}



