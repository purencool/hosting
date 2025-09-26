<?php

namespace App\Console\Commands;

use App\Services\EnvironmentVariables;
use Illuminate\Console\Command;
use App\Services\JsonRequestObject;
use App\Services\AppConfiguration;

/**
 * Class SiteDomainsListUsers
 *
 * The `cli:site:domains:users` console command displays the domains for a specific site.
 *
 * ## Usage
 * ```
 * php artisan cli:site:domains:users {default.domain}
 * ```
 *
 * ## Options
 * This command accepts the following arguments:
 * - `default.domain`: The domain of the site to retrieve the domains for.
 *
 * ## Example Output
 * ```
 * {
 *   "domain": "example.com",
 *   "domains": [
 *     "www.example.com",
 *     "api.example.com"
 *   ]
 * }
 * ```
 *
 * @package App\Console\Commands
 */
class SiteDomainsListUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cli:site:domains:list:users {default.domain?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display the domains for a specific site';

    /**
     * @return void
     */
    public function handle(): void
    {
        $results = (new AppConfiguration())->getDomains($this->argument('default.domain'));
        $this->info(
            json_encode(
                (new JsonRequestObject())->getResults(
                    [
                        'request_type' => 'sites_domains_list_users',
                        'response_format' => 'raw',
                        'request_data' => [
                            'default.domain' => $this->argument('default.domain'),
                            'domains' => $results,
                        ],
                    ]
                ),
                JSON_PRETTY_PRINT
            )
        );
    }
}