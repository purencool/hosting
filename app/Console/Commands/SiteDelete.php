<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\JsonRequestObject;
use App\Services\AppConfiguration;

/**
 * Class SiteDelete
 *
 * The `cli:site:delete` console command deletes a specific site configuration.
 *
 * ## Usage
 * ```
 * php artisan cli:site:delete {default.domain}
 * ```
 *
 * ## Options
 * This command accepts the following arguments:
 * - `default.domain`: The domain of the site to delete the configuration for.
 *
 * ## Example Output
 * ```
 * Site configuration for domain "example.com" has been deleted.
 * ```
 *
 * @package App\Console\Commands
 */
class SiteDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cli:site:delete {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete an existing site configuration';

    /**
     * @return void
     */
    public function handle(): void
    {
        // Get the default domain from the environment variable
        $defaultDomain = env('HOSTING_SITE_DEFAULT_PATH');

        // Create a new instance of AppConfigurationCreators
        $creators = new AppConfiguration();

        // Call the delete method to delete an existing site configuration
        $creators->delete($this->argument('domain'), $defaultDomain);
    }
}