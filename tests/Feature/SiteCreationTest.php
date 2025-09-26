<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use App\Services\AppConfigurationCreators\AppConfiguration;

/**
 *
 */
class SiteCreationTest extends TestCase
{
    /**
     * @return void
     */
    public function test_handle_with_domain_argument()
    {
        $domain = 'example.com';
        Artisan::call('spro:site:creation', ['domain' => $domain]);

        $this->assertNotNull(AppConfiguration::create(['domain' => $domain]));
    }

    /**
     * @return void
     */
    public function test_handle_without_domain_argument()
    {
        Artisan::call('spro:site:creation');

        $this->assertNotNull(AppConfiguration::create(['domain' => 'example.com']));
    }

    /**
     * @return void
     */
    public function test_handle_with_software_type()
    {
        Artisan::call('spro:site:creation', ['--software-type' => 'Laravel']);

        $this->assertNotNull(AppConfiguration::create(['software_type' => 'Laravel']));
    }

    /**
     * @return void
     */
    public function test_handle_with_description()
    {
        Artisan::call('spro:site:creation', ['--description' => 'This is a description']);

        $this->assertNotNull(AppConfiguration::create(['description' => 'This is a description']));
    }

    /**
     * @return void
     */
    public function test_handle_with_container_type()
    {
        Artisan::call('spro:site:creation', ['--container-type' => 'one.yaml']);

        $this->assertNotNull(AppConfiguration::create(['container_type' => 'one.yaml']));
    }

    /**
     * @return void
     */
    public function test_handle_with_git_url_and_auth()
    {
        Artisan::call('spro:site:creation', [
            '--git-url' => 'https://github.com/user/repo.git',
            '--git-auth' => 'username:password'
        ]);

        $this->assertNotNull(AppConfiguration::create(['git_url' => 'https://github.com/user/repo.git', 'git_auth' => 'username:password']));
    }

    /**
     * @return void
     */
    public function test_handle_with_action_update()
    {
        Artisan::call('spro:site:creation', ['--action-update' => 'composer update, next command']);

        $this->assertNotNull(AppConfiguration::create(['action_update' => 'composer update, next command']));
    }

    /**
     * @return void
     */
    public function test_handle_with_entry_points()
    {
        Artisan::call('spro:site:creation', ['--entry-points' => 'example.com, example2.com']);

        $this->assertNotNull(AppConfiguration::create(['entry_points' => 'example.com, example2.com']));
    }

    /**
     * @return void
     */
    public function test_handle_with_environment()
    {
        Artisan::call('spro:site:creation', ['--environment' => 'Development']);

        $this->assertNotNull(AppConfiguration::create(['environment' => 'Development']));
    }

    /**
     * @return void
     */
    public function test_handle_with_database_names()
    {
        Artisan::call('spro:site:creation', ['--database-names' => 'db1, db2']);

        $this->assertNotNull(AppConfiguration::create(['database_names' => 'db1, db2']));
    }
}
