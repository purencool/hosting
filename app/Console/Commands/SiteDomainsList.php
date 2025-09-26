<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Services\JsonRequestObject;
use App\Http\Controllers\Controller as AppRestApi;

/**
 * Class SiteListDomains
 *
 * The `cli:site:domains` console command displays the domains for a specific site.
 *
 * ## Usage
 * ```
 * php artisan cli:site:domains {default.domain}
 * ```
 *
 * ## Options
 * This command accepts the following arguments:
 * - `default.domain`: The domain of the site to retrieve the configuration for.
 *
 * ## Example Output
 * ```
 * {
 *    "environment": "production",
 *    "site": "test.com",
 *    "domain": "test-com-production.test.app"
 *  }
 * ```
 *
 * @package App\Console\Commands
 */
class SiteDomainsList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cli:site:domains:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all domains for all environments';

    /**
     * @return 
     */
    public function handle(): void
    { 
        $this->info(
            json_encode(
                (new JsonRequestObject())->getResults(
                    [ 
                        'request_type' => 'sites_list_domains',
                        'response_format' => 'raw'
                    ]
                ), 
                JSON_PRETTY_PRINT
            )
        );
    }
}
