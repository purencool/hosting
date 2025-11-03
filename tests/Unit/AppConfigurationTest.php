<?php

namespace Tests\Unit;

use App\Services\AppConfigurationCreators\AppConfiguration;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class AppConfigurationTest extends TestCase
{
    public function test_create()
    {
        // Create a mock instance of Storage
        $storage = Mockery::mock('Illuminate\Contracts\Filesystem\Filesystem');
        Storage::shouldReceive('disk')->andReturn($storage);

        // Call the create method to create a new site configuration
        $creators = new AppConfiguration();
        $creators->create('example.com', 'default.domain');

        // Assert that the site configuration was saved to storage
        $this->assertTrue(Storage::disk('local')->has("default.domain/example.com.php"));
    }

    public function test_update()
    {
        // Create a mock instance of Storage
        $storage = Mockery::mock('Illuminate\Contracts\Filesystem\Filesystem');
        Storage::shouldReceive('disk')->andReturn($storage);

        // Call the update method to update an existing site configuration
        $creators = new AppConfigurationCreators();
        $creators->update('example.com', 'default.domain');

        // Assert that the updated site configuration was saved to storage
        $this->assertTrue(Storage::disk('local')->has("default.domain/example.com.php"));
    }

    public function test_delete()
    {
        // Create a mock instance of Storage
        $storage = Mockery::mock('Illuminate\Contracts\Filesystem\Filesystem');
        Storage::shouldReceive('disk')->andReturn($storage);

        // Call the delete method to delete an existing site configuration
        $creators = new AppConfigurationCreators();
        $creators->delete('example.com', 'default.domain');

        // Assert that the site configuration was deleted from storage
        $this->assertFalse(Storage::disk('local')->has("default.domain/example.com.php"));
    }
}